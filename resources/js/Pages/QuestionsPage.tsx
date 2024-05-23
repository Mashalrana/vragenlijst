import React, { useState, useEffect } from 'react';
import CategorySelector from '@/Components/CategorySelector';
import './QuestionsPage.css';

const QuestionsPage: React.FC = () => {
    const [selectedCategory, setSelectedCategory] = useState<string>("");
    const [filenames, setFilenames] = useState<{ id: number, filename: string }[]>([]);

    const handleCategorySelect = async (category: string) => {
        setSelectedCategory(category);
        if (category) {
            try {
                const response = await fetch(`/questions-by-category/${category}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                setFilenames(data);
            } catch (error) {
                console.error('Error fetching filenames:', error);
            }
        } else {
            setFilenames([]);
        }
    };

    const handleReadMoreClick = (filename: string) => {
        window.location.href = `/questions-list/${filename}`;
    };

    const categories = ["zorg", "onderwijs", "technologie"];

    return (
        <div className="page-container">
            <h1 className="page-title">Welkom bij de Vraag en Antwoord Sectie</h1>
            <p className="intro-text">Selecteer een categorie om de vragen te zien</p>
            <div className="dropdown-container">
                <CategorySelector categories={categories} onSelectCategory={handleCategorySelect} />
            </div>

            {selectedCategory && (
                <>
                    <h2 className="category-title">Bestanden voor categorie: {selectedCategory}</h2>
                    {filenames.length > 0 ? (
                        <div className="questions-container">
                            {filenames.map((file) => (
                                <div key={file.id} className="question-card">
                                    <div className="question-content">{file.filename}</div>
                                    <button
                                        onClick={() => handleReadMoreClick(file.filename)}
                                        className="read-more-link"
                                    >
                                        Lees meer
                                    </button>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <p className="no-results-message">Geen resultaten gevonden</p>
                    )}
                </>
            )}
        </div>
    );
};

export default QuestionsPage;
