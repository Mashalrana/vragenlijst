import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import './AnswerPage.css';

interface Answer {
    id: number;
    option_1: string | null;
    option_2: string | null;
    option_3: string | null;
    option_4: string | null;
}

const AnswerPage: React.FC = () => {
    const { filename } = useParams<{ filename: string }>();
    const [questions, setQuestions] = useState<{ id: number, content: string, answers: Answer[] }[]>([]);

    useEffect(() => {
        const fetchQuestionsAndAnswers = async () => {
            try {
                const response = await fetch(`/questions-by-filename/${filename}`);
                const data = await response.json();
                setQuestions(data);
            } catch (error) {
                console.error('Error fetching questions and answers:', error);
            }
        };

        fetchQuestionsAndAnswers();
    }, [filename]);

    return (
        <div className="answer-page">
            <h1>Antwoorden voor bestand: {filename}</h1>
            <div className="questions-container">
                {questions.map((question) => (
                    <div key={question.id} className="question-card">
                        <h2>{question.content}</h2>
                        <div className="answers-container">
                            {question.answers.map((answer, index) => (
                                <div key={index} className="answer-card">
                                    {answer.option_1 && <p>{answer.option_1}</p>}
                                    {answer.option_2 && <p>{answer.option_2}</p>}
                                    {answer.option_3 && <p>{answer.option_3}</p>}
                                    {answer.option_4 && <p>{answer.option_4}</p>}
                                </div>
                            ))}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default AnswerPage;
