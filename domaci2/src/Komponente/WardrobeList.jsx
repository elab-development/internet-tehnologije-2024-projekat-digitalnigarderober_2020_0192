import React, { useState } from 'react';
import useWardrobes from './useWardrobes';
import './WardrobeList.css';

const WardrobeList = () => {
  const [wardrobes, addWardrobe, deleteWardrobe] = useWardrobes();
  const [naziv, setNaziv] = useState('');
  const [opis, setOpis] = useState('');

  const handleAddWardrobe = (e) => {
    e.preventDefault();
    if (naziv.trim() === '') {
      alert('Naziv je obavezan.');
      return;
    }
    addWardrobe(naziv, opis);
    setNaziv('');
    setOpis('');
  };

  return (
    <section className="wardrobe-section">
      <h2 className="section-title">Moji garderoberi</h2>
      <form className="add-wardrobe-form" onSubmit={handleAddWardrobe}>
        <input
          type="text"
          placeholder="Naziv garderobera"
          value={naziv}
          onChange={(e) => setNaziv(e.target.value)}
          required
        />
        <textarea
          placeholder="Opis garderobera (opciono)"
          value={opis}
          onChange={(e) => setOpis(e.target.value)}
        />
        <button type="submit" className="add-button">
          Dodaj garderober
        </button>
      </form>
      <div className="wardrobe-grid">
        {wardrobes.length > 0 ? (
          wardrobes.map((wardrobe) => (
            <div className="wardrobe-card" key={wardrobe.id}>
              <div className="wardrobe-info">
                <h3 className="wardrobe-name">{wardrobe.naziv}</h3>
                <p className="wardrobe-description">{wardrobe.opis}</p>
              </div>
              <button
                className="delete-button"
                onClick={() => deleteWardrobe(wardrobe.id)}
              >
                Obriši
              </button>
            </div>
          ))
        ) : (
          <p>Nema garderobera za prikaz.</p>
        )}
      </div>
    </section>
  );
};

export default WardrobeList;
