import React from 'react';
import './HomePage.css';

const HomePage = () => {
  return (
    <div className="homepage">
      <header className="hero-section">
        <div className="hero-content">
          <h1 className="hero-title">
            <span className="highlight">Tvoj digitalni garderober</span>
          </h1>
          <p className="hero-subtitle">Organiziraj, inspiriši se i obuci se s lakoćom</p>
          <button className="cta-button">Započni sada</button>
        </div>
        <div className="hero-overlay"></div>
      </header>

      <section className="featured-collection">
        <h2 className="section-title">Najnovija Kolekcija</h2>
        <div className="items-grid">
          {Array.from({ length: 6 }).map((_, i) => (
            <div className="item-card" key={i}>
              <div className="item-image">
                <img src={`https://source.unsplash.com/collection/190727/300x300?sig=${i}`} alt="Komad odjeće" />
              </div>
              <div className="item-info">
                <h3 className="item-name">Komad #{i+1}</h3>
                <p className="item-description">Ekskluzivan modni komad, savršen za posebne prilike</p>
                <button className="item-cta-button">Detalji</button>
              </div>
            </div>
          ))}
        </div>
      </section>

      <section className="benefits-section">
        <h2 className="section-title">Zašto Digitalni Garderober?</h2>
        <div className="benefits-grid">
          <div className="benefit-card">
            <div className="benefit-icon">👗</div>
            <h3>Organizacija</h3>
            <p>Brzo pronađi sve komade, sortiraj, filtriraj i kreiraj outfite.</p>
          </div>
          <div className="benefit-card">
            <div className="benefit-icon">💡</div>
            <h3>Inspiracija</h3>
            <p>Preporuke trendova, kombinacija boja i stilskih savjeta.</p>
          </div>
          <div className="benefit-card">
            <div className="benefit-icon">⚡</div>
            <h3>Efikasnost</h3>
            <p>Uštedi vrijeme pri odabiru odjevnih kombinacija svakog jutra.</p>
          </div>
        </div>
      </section>

      <footer className="footer">
        <p>© 2024 Digitalni Garderober. Sva prava zadržana.</p>
      </footer>
    </div>
  );
};

export default HomePage;
