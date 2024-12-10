import React from 'react';
import './RegisterForm.css';  

const InputField = ({ label, type="text", name, value, onChange, ...props }) => {
  return (
    <div className="input-field">
      <label htmlFor={name} className="input-label">{label}</label>
      <input 
        type={type} 
        name={name} 
        id={name}
        value={value} 
        onChange={onChange} 
        className="styled-input"
        {...props}
      />
      <div className="input-underline"></div>
    </div>
  );
};

export default InputField;
