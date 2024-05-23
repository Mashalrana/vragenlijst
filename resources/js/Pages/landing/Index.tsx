import React, { useState } from "react";
import UploadButton from "@/Components/uploadbutton";
import CategorySelector from "@/Components/CategorySelector";

const Index: React.FC = () => {
  const [selectedCategory, setSelectedCategory] = useState<string>("");
  const [uploadedFile, setUploadedFile] = useState<File | null>(null);
  const [filename, setFilename] = useState<string>("");

  const handleCategorySelect = (category: string) => {
    setSelectedCategory(category);
  };

  const handleFileUpload = (file: File) => {
    console.log("Bestand geüpload:", file);
    setUploadedFile(file);
    setFilename(file.name); // Gebruik de bestandsnaam voor de filename
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (selectedCategory && uploadedFile) {
      const formData = new FormData();
      formData.append('file', uploadedFile);
      formData.append('category', selectedCategory);
      formData.append('filename', filename); // Voeg de filename toe aan de formData

      // Fetch CSRF token from the meta tag
      const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
      if (!csrfTokenMeta) {
        console.error("CSRF token meta tag not found. Make sure your Blade template includes the meta tag.");
        alert("CSRF token meta tag not found. Please make sure you are using the correct Blade template.");
        return;
      }

      const csrfToken = csrfTokenMeta.getAttribute('content');
      if (!csrfToken) {
        console.error("CSRF token content is missing.");
        alert("CSRF token content is missing. Please check your Blade template.");
        return;
      }

      formData.append('_token', csrfToken);

      try {
        const response = await fetch('http://127.0.0.1:8000/upload-excel', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': csrfToken,
          },
        });
        const data = await response.json();
        if (data.success) {
          console.log("Bestand succesvol verzonden:", data.filepath);
          alert('Bestand succesvol geüpload!');
        } else {
          console.error("Fout bij uploaden:", data.error);
          alert('Er is een fout opgetreden bij het uploaden.');
        }
      } catch (error) {
        console.error('Fout:', error);
        alert('Er is een fout opgetreden bij het uploaden.');
      }
    } else {
      console.error("Selecteer een categorie en upload een bestand.");
      alert('Selecteer een categorie en upload een bestand.');
    }
  };

  const categories = ["zorg", "onderwijs", "technologie"]; // Voeg hier je categorieën toe

  return (
    <div>
      <h1>Upload Knop voor Excel-bestanden</h1>
      <form onSubmit={handleSubmit} encType="multipart/form-data">
        <UploadButton onFileUpload={handleFileUpload} />

        <h1>Categorie-weergave</h1>
        <CategorySelector
          categories={categories}
          onSelectCategory={handleCategorySelect}
        />

        <button 
          type="submit"
          style={{
            padding: "10px 20px",
            backgroundColor: "#4CAF50",
            color: "white",
            border: "none",
            borderRadius: "5px",
            cursor: "pointer",
          }}
        >
          Verzend
        </button>
      </form>
    </div>
  );
};

export default Index;
