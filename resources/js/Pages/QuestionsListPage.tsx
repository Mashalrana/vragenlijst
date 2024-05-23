import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import './QuestionsListPage.css';

const QuestionsListPage: React.FC = () => {
    const { filename } = useParams<{ filename: string }>();
    const [questions, setQuestions] = useState<{ id: number, content: string, answers: { option_1: string | null, option_2: string | null, option_3: string | null, option_4: string | null }[] }[]>([]);

    useEffect(() => {
        const fetchQuestions = async () => {
            try {
                const response = await fetch(`/questions-by-filename/${filename}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                setQuestions(data);
            } catch (error) {
                console.error('Error fetching questions:', error);
            }
        };

        fetchQuestions();
    }, [filename]);

    return (
        <div className="questions-list-page">
            <h1>Vragenlijst: {filename}</h1>
            <div className="questions-container">
                {questions.length > 0 ? (
                    questions.map((question) => (
                        <div key={question.id} className="question-card">
                            <div className="question-content">{question.content}</div>
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
                    ))
                ) : (
                    <p>Geen vragen gevonden</p>
                )}
            </div>
        </div>
    );
};

export default QuestionsListPage;
