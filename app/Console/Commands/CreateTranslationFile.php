<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;

class CreateTranslationFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:create {copyFromLocale} {locale?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new translation file for a given locale based on another locale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $copyFromLocale = $this->argument('copyFromLocale');
        $locale = $this->argument('locale');

        if ($locale) {
            $this->translate($locale, $copyFromLocale);
            return;
        }

        $locales = [
            'nl',
            'ch',
            'en',
            'se',
            'pl',
            'fi',
            'es',
            'de',
            'da',
            'fr',
            'it',
            'no',
            'pt',
            'ro',
            'ru',
            'tr',
        ];

        $this->info("Creating translation files for all locales...");

        foreach ($locales as $locale) {
            exec("php artisan translation:create $copyFromLocale $locale > /dev/null 2>&1 &");
        }

        // Wait for all processes to finish
        while (true) {
            $running = false;
            $runningArray = [];
            exec("ps aux | grep 'artisan translation:create' | grep -v grep", $output);

            foreach ($output as $line) {
                foreach ($locales as $locale) {
                    if (strpos($line, "php artisan translation:create $copyFromLocale $locale")) {
                        $running = true;
                        $runningArray[] = $locale;
                        break;
                    }
                }
            }

            if (!$running) {
                break;
            } else {
                echo "\033[2J";
                // show the running processes (including the amount of lines that the file currently has)
                foreach ($locales as $locale) {
                    $this->info("Creating translation file for \"$locale\"... \033[1;32m[" . (file_exists(lang_path($locale . '.json')) ? count(json_decode(file_get_contents(lang_path($locale . '.json')), true)) : 0) . "/" . count(json_decode(file_get_contents(lang_path($copyFromLocale . '.json')), true)) . "]\033[0m");
                }
            }

            sleep(1);
        }

        $this->info("All translation files created successfully!");
    }


    public function translate($locale, $copyFromLocale)
    {
        if ($locale === $copyFromLocale) {
            $this->error("The locale \"$locale\" is the same as the locale to copy from \"$copyFromLocale\"!");
            return;
        }

        $this->info('__________' . strtoupper($locale) . '__________');

        $original_file = json_decode(file_get_contents(lang_path($copyFromLocale . '.json')), true);

        $chucks = [];
        $currentChuck = [];
        $tokens = 0;

        foreach ($original_file as $key => $value) {
            $currentTokenCount = (strlen($key) + strlen($value)) / 1;

            if (($tokens + $currentTokenCount) > 4096) {
                $chucks[] = $currentChuck;
                $currentChuck = [];
                $tokens = 0;
            }

            $currentChuck[$key] = $value;
            $tokens += $currentTokenCount;
        }

        if (!empty ($currentChuck)) {
            $chucks[] = $currentChuck;
        }

        // check that all original keys are present in the new file
        foreach ($original_file as $key => $value) {
            $found = false;

            foreach ($chucks as $chuck) {
                if (array_key_exists($key, $chuck)) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $this->error("The key \"$key\" was not found in the translation file for \"$locale\"!");
                return;
            }
        }

        $this->info("Creating translation file for \"$locale\"...");

        $return = [];

        foreach ($chucks as $key => $chuck) {
            for ($retry = 0; $retry < 3; $retry++) {

                try {
                    $stream = OpenAI::chat()
                        ->createStreamed([
                            'model' => 'gpt-3.5-turbo-16k',
                            'messages' => [
                                [
                                    "role" => "system",
                                    "content" => "You will be provided with a translation file this translation file should be translated into \"" . strtoupper($locale) . "\".",
                                ],
                                [
                                    'role' => 'user',
                                    'content' => json_encode($chuck, JSON_PRETTY_PRINT),
                                ]
                            ],
                            "temperature" => 0,
                            "max_tokens" => 12288,
                            "presence_penalty" => 1,
                        ]);

                    $translation = "";
                    foreach ($stream as $response) {
                        $toAdd = $response->choices[0]->toArray();

                        if (array_key_exists("delta", $toAdd)) {
                            if (array_key_exists("content", $toAdd['delta'])) {
                                $translation .= $toAdd['delta']['content'];
                                continue;
                            } elseif (array_key_exists("finish_reason", $toAdd['delta'])) {
                                if ($toAdd['delta']['finish_reason'] === "stop") {
                                    break;
                                }
                            }
                        } else {
                            logger()->error("Something went wrong while creating the translation file for \"$locale\"!");
                            logger()->info($response);
                            $this->error("Something went wrong while creating the translation file for \"$locale\"!");
                        }
                    }

                    echo $translation . "\n";

                    $arr = json_decode($translation, true);

                    if ($arr === null) {
                        $translation = substr($translation, 0, strrpos($translation, ","));
                        $arr = json_decode($translation, true);
                    }

                    if ($arr !== null) {
                        $return = array_merge($return, $arr);
                        file_put_contents(lang_path($locale . '.json'), json_encode($return, JSON_PRETTY_PRINT));
                        $this->info("Updated translation file for \"$locale\"! (" . ($key + 1) . "/" . count($chucks) . ")");
                        break;
                    } else {
                        $this->error("Failed to create translation file for \"$locale\"!");
                    }
                } catch (Exception $e) {
                    logger()->error("Something went wrong while creating the translation file for \"$locale\"!");
                    logger()->info($e->getMessage());
                    $this->error("Something went wrong while creating the translation file for \"$locale\"!");

                    if ($retry === 2) {
                        $this->error("Failed to create translation file for \"$locale\"!");
                        return;
                    } else {
                        $this->info("Retrying...");
                    }
                }
            }
        }

        file_put_contents(lang_path($locale . '.json'), json_encode($return, JSON_PRETTY_PRINT));

        $this->info("Translation file for \"$locale\" created successfully!");
    }
}
