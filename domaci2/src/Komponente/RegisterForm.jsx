import React, { useState } from 'react';
import axios from 'axios';
import InputField from './InputField';
import PrimaryButton from './PrimaryButton';
import './RegisterForm.css';
import { useNavigate } from 'react-router-dom';

const RegisterForm = () => {
  let navigate = useNavigate();
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
  const [passwordVisible, setPasswordVisible] = useState(false);

  const totalSteps = 3;

  const handleChange = (e) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
    setErrorMessages({});
  };

  const handleNext = () => {
    if (validateStep(currentStep)) {
      setCurrentStep(currentStep + 1);
    }
  };

  const handleBack = () => {
    if (currentStep > 1) {
      setCurrentStep(currentStep - 1);
    }
  };

  const validateStep = (step) => {
    const errors = {};
    if (step === 1) {
      if (!formData.ime) errors.ime = 'Ime je obavezno.';
      if (!formData.prezime) errors.prezime = 'Prezime je obavezno.';
      if (!formData.email || !/\S+@\S+\.\S+/.test(formData.email)) {
        errors.email = 'Unesite validnu e-mail adresu.';
      }
    }
    if (step === 2) {
      if (!formData.password || formData.password.length < 8) {
        errors.password = 'Lozinka mora imati najmanje 8 karaktera.';
      }
      if (formData.password !== formData.password_confirmation) {
        errors.password_confirmation = 'Lozinke se ne podudaraju.';
      }
    }
    setErrorMessages(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!validateStep(currentStep)) return;

    setLoading(true);
    setErrorMessages({});
    setSuccessMessage('');

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/register', formData);
      alert('Registracija uspešna! Dobro došli.');
      navigate('/login')
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
        <h2 className="form-title">Kreiraj nalog</h2>
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
                  required
                />
                {errorMessages.ime && <div className="error-message">{errorMessages.ime}</div>}
              </div>

              <div className="form-row">
                <InputField 
                  label="Prezime" 
                  name="prezime" 
                  value={formData.prezime} 
                  onChange={handleChange} 
                  required
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
                  required
                />
                {errorMessages.email && <div className="error-message">{errorMessages.email}</div>}
              </div>
            </>
          )}

          {currentStep === 2 && (
            <>
              <div className="form-row password-row">
                <InputField 
                  label="Lozinka"
                  type={passwordVisible ? 'text' : 'password'} 
                  name="password" 
                  value={formData.password} 
                  onChange={handleChange} 
                  required
                />
                <button
                  type="button"
                  className="toggle-password"
                  onClick={() => setPasswordVisible(!passwordVisible)}
                >
                  {passwordVisible ? 'Sakrij' : 'Prikaži'}
                </button>
                {errorMessages.password && <div className="error-message">{errorMessages.password}</div>}
              </div>

              <div className="form-row">
                <InputField 
                  label="Potvrda Lozinke" 
                  type={passwordVisible ? 'text' : 'password'} 
                  name="password_confirmation" 
                  value={formData.password_confirmation} 
                  onChange={handleChange} 
                  required
                />
                {errorMessages.password_confirmation && (
                  <div className="error-message">{errorMessages.password_confirmation}</div>
                )}
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
