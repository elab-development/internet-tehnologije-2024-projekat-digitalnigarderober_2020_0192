import React from 'react';
import './RegisterForm.css';  

const PrimaryButton = ({ children, onClick, type="button", disabled }) => {
  return (
    <button className="primary-button" onClick={onClick} type={type} disabled={disabled}>
      {children}
    </button>
  );
};

export default PrimaryButton;
