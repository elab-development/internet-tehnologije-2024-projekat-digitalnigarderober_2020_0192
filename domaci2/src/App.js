import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import './App.css';
import HomePage from './Komponente/HomePage';
import RegisterForm from './Komponente/RegisterForm';
import LoginForm from './Komponente/LoginForm';
import Navbar from './Komponente/Navbar';

function App() {
  return (
    <Router>
      <div className="App">
       <Navbar />
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/register" element={<RegisterForm />} />
          <Route path="/login" element={<LoginForm />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
