import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Navbar.css';

const Navbar = () => {
  const navigate = useNavigate();
  const isAuthenticated = !!sessionStorage.getItem('token');  

  const handleLogout = async () => {
    try {
      const token = sessionStorage.getItem('token');
      await axios.post(
        'http://127.0.0.1:8000/api/logout',
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );
      sessionStorage.removeItem('token');
      alert('Uspešno ste se odjavili.');
      navigate('/login'); // Preusmeravanje na login stranicu
    } catch (error) {
      console.error('Greška prilikom odjave:', error);
      alert('Došlo je do greške. Pokušajte ponovo.');
    }
  };

  return (
    <nav className="navbar">
      <div className="navbar-brand">
        <Link to="/">Digitalni Garderober</Link>
      </div>
      <ul className="navbar-links">
        <li>
          <Link to="/">Početna</Link>
        </li>
        {!isAuthenticated ? (
          <>
            <li>
              <Link to="/register">Registracija</Link>
            </li>
            <li>
              <Link to="/login">Prijava</Link>
            </li>
          </>
        ) : (
          <li>
            <button onClick={handleLogout} className="logout-button">
              Odjava
            </button>
          </li>
        )}
      </ul>
    </nav>
  );
};

export default Navbar;
