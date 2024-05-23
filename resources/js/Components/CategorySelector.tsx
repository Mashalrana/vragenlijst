import React from "react";

interface CategorySelectorProps {
  categories: string[];
  onSelectCategory: (category: string) => void;
}

const CategorySelector: React.FC<CategorySelectorProps> = ({
  categories,
  onSelectCategory,
}) => {
  const handleCategoryChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const selectedCategory = e.target.value;
    onSelectCategory(selectedCategory);
  };

  return (
    <div>
      <select onChange={handleCategoryChange} defaultValue="">
        <option value="" disabled>Selecteer een categorie</option>
        {categories.map((category, index) => (
          <option key={index} value={category}>
            {category}
          </option>
        ))}
      </select>
    </div>
  );
};

export default CategorySelector;
