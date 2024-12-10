import React, { useState } from 'react';
import axios from 'axios';
import InputField from './InputField';
import PrimaryButton from './PrimaryButton';
import './RegisterForm.css';

const RegisterForm = () => {
  const [currentStep, setCurrentStep] = useState(1);
  const [formData, setFormData] = useState({
    ime: '',
    prezime: '',
    email: '',
    password: '',
    password_confirmation: '',
    avatar: '',
    datum_rodjenja: '',
    telefon: '',
    adresa: '',
    biografija: ''
  });

  const [loading, setLoading] = useState(false);
  const [errorMessages, setErrorMessages] = useState({});
  const [successMessage, setSuccessMessage] = useState('');

  const totalSteps = 3;

  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
    setErrorMessages({});
  };

  const handleNext = () => {
    if (currentStep < totalSteps) {
      setCurrentStep(currentStep + 1);
    }
  };

  const handleBack = () => {
    if (currentStep > 1) {
      setCurrentStep(currentStep - 1);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrorMessages({});
    setSuccessMessage('');

    try {
      const response = await axios.post('/api/register', formData);
      setSuccessMessage('Registracija uspješna! Dobro došli.');
      setLoading(false);
    } catch (error) {
      setLoading(false);
      if (error.response && error.response.status === 422) {
        setErrorMessages(error.response.data);
      } else {
        setErrorMessages({ general: 'Došlo je do greške. Pokušajte ponovo kasnije.' });
      }
    }
  };

  return (
    <div className="form-container">
      <div className="form-wrapper">
        <h2 className="form-title">Kreiraj Nalog</h2>
        <p className="form-subtitle">Korak {currentStep} od {totalSteps}</p>

        <div className="progress-bar">
          <div
            className="progress-bar-inner"
            style={{ width: `${(currentStep / totalSteps) * 100}%` }}
          ></div>
        </div>

        {successMessage && <div className="success-message">{successMessage}</div>}
        {errorMessages.general && <div className="error-message">{errorMessages.general}</div>}

        <form onSubmit={handleSubmit} className="registration-form">
          {currentStep === 1 && (
            <>
              <div className="form-row">
                <InputField 
                  label="Ime" 
                  name="ime" 
                  value={formData.ime} 
                  onChange={handleChange} 
                />
                {errorMessages.ime && <div className="error-message">{errorMessages.ime}</div>}
              </div>

              <div className="form-row">
                <InputField 
                  label="Prezime" 
                  name="prezime" 
                  value={formData.prezime} 
                  onChange={handleChange} 
                />
                {errorMessages.prezime && <div className="error-message">{errorMessages.prezime}</div>}
              </div>

              <div className="form-row">
                <InputField 
                  label="Email"
                  type="email" 
                  name="email" 
                  value={formData.email} 
                  onChange={handleChange} 
                />
                {errorMessages.email && <div className="error-message">{errorMessages.email}</div>}
              </div>
            </>
          )}

          {currentStep === 2 && (
            <>
              <div className="form-row">
                <InputField 
                  label="Lozinka"
                  type="password" 
                  name="password" 
                  value={formData.password} 
                  onChange={handleChange} 
                />
                {errorMessages.password && <div className="error-message">{errorMessages.password}</div>}
              </div>

              <div className="form-row">
                <InputField 
                  label="Potvrda Lozinke" 
                  type="password" 
                  name="password_confirmation" 
                  value={formData.password_confirmation} 
                  onChange={handleChange} 
                />
              </div>

              <div className="form-row">
                <InputField 
                  label="Avatar (URL)" 
                  name="avatar" 
                  value={formData.avatar} 
                  onChange={handleChange} 
                />
              </div>
            </>
          )}

          {currentStep === 3 && (
            <>
              <div className="form-row">
                <InputField 
                  label="Datum Rođenja"
                  type="date" 
                  name="datum_rodjenja" 
                  value={formData.datum_rodjenja} 
                  onChange={handleChange} 
                />
              </div>

              <div className="form-row">
                <InputField 
                  label="Telefon" 
                  name="telefon" 
                  value={formData.telefon} 
                  onChange={handleChange} 
                />
              </div>

              <div className="form-row">
                <InputField 
                  label="Adresa" 
                  name="adresa" 
                  value={formData.adresa} 
                  onChange={handleChange} 
                />
              </div>

              <div className="form-row">
                <InputField 
                  label="Biografija" 
                  name="biografija" 
                  value={formData.biografija} 
                  onChange={handleChange} 
                />
              </div>
            </>
          )}

          <div className="button-row">
            {currentStep > 1 && (
              <PrimaryButton type="button" onClick={handleBack}>
                Nazad
              </PrimaryButton>
            )}
            {currentStep < totalSteps && (
              <PrimaryButton type="button" onClick={handleNext}>
                Dalje
              </PrimaryButton>
            )}
            {currentStep === totalSteps && (
              <PrimaryButton type="submit" disabled={loading}>
                {loading ? 'Registrujem...' : 'Registruj se'}
              </PrimaryButton>
            )}
          </div>
        </form>
      </div>
    </div>
  );
};

export default RegisterForm;
