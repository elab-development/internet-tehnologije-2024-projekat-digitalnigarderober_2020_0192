import React from 'react';
import useWardrobes from './useWardrobes';
import './WardrobeList.css';

const WardrobeList = () => {
  const [wardrobes] = useWardrobes();
 
  return (
    <section className="wardrobe-section">
      <h2 className="section-title">Moji Garderoberi</h2>
      <div className="wardrobe-grid">
        {wardrobes.length > 0 ? (
          wardrobes.map((wardrobe, index) => (
            <div className="wardrobe-card" key={index}>
              <div className="wardrobe-info">
                <h3 className="wardrobe-name">{wardrobe.naziv}</h3>
                <p className="wardrobe-description">{wardrobe.opis}</p>
              </div>
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
