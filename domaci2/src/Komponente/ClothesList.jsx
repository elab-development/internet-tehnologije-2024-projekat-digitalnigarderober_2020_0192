import React from 'react';
import { useParams } from 'react-router-dom';
import useClothes from './useClothes';
import './ClothesList.css';

const ClothesList = () => {
  const { id } = useParams();
  const [clothes, , deleteCloth] = useClothes(id);

  return (
    <section className="clothes-section">
      <h2 className="section-title">Odeća u garderoberu</h2>
      <table className="clothes-table">
        <thead>
          <tr>
            <th>Slika</th>
            <th>Naziv</th>
            <th>Tip</th>
            <th>Boja</th>
            <th>Sezona</th>
            <th>Materijal</th>
            <th>Akcije</th>
          </tr>
        </thead>
        <tbody>
          {clothes.length > 0 ? (
            clothes.map((cloth) => (
              <tr key={cloth.id}>
                <td>
                  {cloth.slika ? (
                    <img src={cloth.slika} alt={cloth.naziv} className="cloth-image" />
                  ) : (
                    'Nema slike'
                  )}
                </td>
                <td>{cloth.naziv}</td>
                <td>{cloth.tip}</td>
                <td>{cloth.boja}</td>
                <td>{cloth.sezona}</td>
                <td>{cloth.materijal || 'N/A'}</td>
                <td>
                  <button
                    className="delete-button"
                    onClick={() => deleteCloth(cloth.id)}
                  >
                    Obriši
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="7">Nema odeće za prikaz.</td>
            </tr>
          )}
        </tbody>
      </table>
    </section>
  );
};

export default ClothesList;
