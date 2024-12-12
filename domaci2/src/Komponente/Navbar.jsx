import React, { useContext } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Navbar.css';
import { AuthContext } from './AuthContext';
 
const Navbar = () => {
  const { user, setUser } = useContext(AuthContext);
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      const token = sessionStorage.getItem('token');
      console.log(token)
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
      setUser(null); // Brisanje korisnika iz globalnog stanja
      navigate('/login');
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
        {!user ? (
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
