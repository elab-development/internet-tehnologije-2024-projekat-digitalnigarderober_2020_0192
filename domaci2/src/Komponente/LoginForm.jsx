import React, { useState, useContext } from 'react';
import axios from 'axios';
import InputField from './InputField';
import PrimaryButton from './PrimaryButton';
import './RegisterForm.css';
import { AuthContext } from './AuthContext';
import { useNavigate } from 'react-router-dom';


const LoginForm = () => {
  let navigate= useNavigate();
  const { setUser } = useContext(AuthContext);
  const [formData, setFormData] = useState({
    email: 'tijanajeremic@gmail.com',
    password: 'tijanajeremic',
  });

  const [loading, setLoading] = useState(false);
  const [errorMessages, setErrorMessages] = useState({});
  const [passwordVisible, setPasswordVisible] = useState(false);
  const [successMessage, setSuccessMessage] = useState('');

  const handleChange = (e) => {
    setFormData((prev) => ({ ...prev, [e.target.name]: e.target.value }));
    setErrorMessages({});
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrorMessages({});
    setSuccessMessage('');

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/login', formData);
      const { access_token, user } = response.data; // Pretpostavljamo da API vraća token i podatke o korisniku

      sessionStorage.setItem('token', access_token); // Čuvanje tokena
      setUser(user); // Ažuriranje korisnika u globalnom stanju
      setSuccessMessage('Prijava uspešna! Dobro došli.');
      setLoading(false);
      navigate('/mojgarderober')
    } catch (error) {
      setLoading(false);
      if (error.response && error.response.status === 401) {
        setErrorMessages({ general: 'Neispravni kredencijali. Pokušajte ponovo.' });
      } else {
        setErrorMessages({ general: 'Došlo je do greške. Pokušajte kasnije.' });
      }
    }
  };

  return (
    <div className="form-container">
      <div className="form-wrapper">
        <h2 className="form-title">Prijava</h2>
        <p className="form-subtitle">Unesite svoje podatke za prijavu</p>

        {successMessage && <div className="success-message">{successMessage}</div>}
        {errorMessages.general && <div className="error-message">{errorMessages.general}</div>}

        <form onSubmit={handleSubmit} className="registration-form">
          <div className="form-row">
            <InputField
              label="Email"
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              required
            />
          </div>

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
          </div>

          <div className="button-row">
            <PrimaryButton type="submit" disabled={loading}>
              {loading ? 'Prijavljujem...' : 'Prijavi se'}
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  );
};

export default LoginForm;
