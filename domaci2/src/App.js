import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import './App.css';
import HomePage from './Komponente/HomePage';
import RegisterForm from './Komponente/RegisterForm';
import LoginForm from './Komponente/LoginForm';
import Navbar from './Komponente/Navbar';
import { AuthProvider } from './Komponente/AuthContext';
import WardrobeList from './Komponente/WardrobeList';
 

function App() {
  return (
    <AuthProvider>
      <Router>
        <div className="App">
          <Navbar />
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/register" element={<RegisterForm />} />
            <Route path="/login" element={<LoginForm />} />
            <Route path="/mojgarderober" element={<WardrobeList />} />
          </Routes>
        </div>
      </Router>
    </AuthProvider>
  );
}

export default App;
