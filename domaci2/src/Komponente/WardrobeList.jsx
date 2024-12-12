import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import useWardrobes from './useWardrobes';
import './WardrobeList.css';

const WardrobeList = () => {
  const [wardrobes, addWardrobe, deleteWardrobe] = useWardrobes();
  const [naziv, setNaziv] = useState('');
  const [opis, setOpis] = useState('');
  const [searchTerm, setSearchTerm] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 5;

  // Filtriranje garderobera prema nazivu
  const filteredWardrobes = wardrobes.filter((wardrobe) =>
    wardrobe.naziv.toLowerCase().includes(searchTerm.toLowerCase())
  );

  // Proračun za prikaz na trenutnoj stranici
  const indexOfLastItem = currentPage * itemsPerPage;
  const indexOfFirstItem = indexOfLastItem - itemsPerPage;
  const currentWardrobes = filteredWardrobes.slice(indexOfFirstItem, indexOfLastItem);

  const totalPages = Math.ceil(filteredWardrobes.length / itemsPerPage);

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

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value);
    setCurrentPage(1); // Resetuje na prvu stranicu prilikom pretrage
  };

  return (
    <section className="wardrobe-section">
      <h2 className="section-title">Moji garderoberi</h2>
 


      {/* Dodavanje garderobera */}
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

      {/* Prikaz garderobera */}
      <div className="filters">
        <input
            type="text"
            placeholder="Pretraži garderobere po nazivu"
            value={searchTerm}
            onChange={handleSearchChange}
            className="search-input"
        />
        <i className="search-icon fas fa-search"></i>
        </div>
      <div className="wardrobe-grid">
        {currentWardrobes.length > 0 ? (
          currentWardrobes.map((wardrobe) => (
            <div className="wardrobe-card" key={wardrobe.id}>
              <div className="wardrobe-info">
                <h3 className="wardrobe-name">{wardrobe.naziv}</h3>
                <p className="wardrobe-description">{wardrobe.opis}</p>
                <Link to={`/garderober/${wardrobe.id}/odeca`} className="view-clothes-link">
                  Prikaži odeću
                </Link>
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

      {/* Paginacija */}
      {totalPages > 1 && (
        <div className="pagination">
          <button
            disabled={currentPage === 1}
            onClick={() => setCurrentPage((prev) => prev - 1)}
          >
            Prethodna
          </button>
          <span>
            Stranica {currentPage} od {totalPages}
          </span>
          <button
            disabled={currentPage === totalPages}
            onClick={() => setCurrentPage((prev) => prev + 1)}
          >
            Sledeća
          </button>
        </div>
      )}
    </section>
  );
};

export default WardrobeList;
