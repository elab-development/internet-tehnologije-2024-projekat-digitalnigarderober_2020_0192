import React from 'react';
import { useParams } from 'react-router-dom';
import useClothes from './useClothes';
import './ClothesList.css';

const ClothesList = () => {
  const { id } = useParams();  
  const [clothes] = useClothes(id);

  return (
    <section className="clothes-section">
      <h2 className="section-title">Odeća u garderoberu</h2>
      <table className="clothes-table">
        <thead>
          <tr>
            <th>Naziv</th>
            <th>Tip</th>
            <th>Boja</th>
            <th>Sezona</th>
            <th>Materijal</th>
          </tr>
        </thead>
        <tbody>
          {clothes.length > 0 ? (
            clothes.map((cloth) => (
              <tr key={cloth.id}>
                <td>{cloth.naziv}</td>
                <td>{cloth.tip}</td>
                <td>{cloth.boja}</td>
                <td>{cloth.sezona}</td>
                <td>{cloth.materijal || 'N/A'}</td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5">Nema odeće za prikaz.</td>
            </tr>
          )}
        </tbody>
      </table>
    </section>
  );
};

export default ClothesList;
