import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import CategorySelector from '@/Components/CategorySelector';
import './QuestionsPage.css';

const QuestionsPage: React.FC = () => {
  const [selectedCategory, setSelectedCategory] = useState<string>("");
  const [questions, setQuestions] = useState<{ id: number, content: string }[]>([]);

  const handleCategorySelect = async (category: string) => {
    setSelectedCategory(category);
    if (category) {
      try {
        const response = await fetch(`/questions-by-category/${category}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        setQuestions(data);
      } catch (error) {
        console.error('Error fetching questions:', error);
      }
    } else {
      setQuestions([]);
    }
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
          <h2 className="category-title">Vragen voor categorie: {selectedCategory}</h2>
          <div className="questions-container">
            {questions.map((question) => (
              <div key={question.id} className="question-card">
                <div className="question-content">{question.content}</div>
                <Link to={`/answers/${question.id}`} className="read-more-link">
                  Lees meer
                </Link>
              </div>
            ))}
          </div>
        </>
      )}
    </div>
  );
};

export default QuestionsPage;
