import React from "react";

interface UploadButtonProps {
  onFileUpload: (file: File) => void;
}

const UploadButton: React.FC<UploadButtonProps> = ({ onFileUpload }) => {
  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files && e.target.files[0];
    if (file) {
      onFileUpload(file);
    }
  };

  return (
    <div>
      <input type="file" accept=".csv, .txt" onChange={handleFileChange} />
    </div>
  );
};

export default UploadButton;
