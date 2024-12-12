import React, { useState } from 'react';
import { useParams } from 'react-router-dom';
import useClothes from './useClothes';
import './ClothesList.css';

const ClothesList = () => {
  const { id } = useParams();
  const [clothes, , createCloth, deleteCloth] = useClothes(id);

  const [newCloth, setNewCloth] = useState({
    naziv: '',
    tip: '',
    boja: '',
    sezona: '',
    materijal: '',
    garderober_id: id,
    slika: null,
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setNewCloth((prev) => ({ ...prev, [name]: value }));
  };

  const handleFileChange = (e) => {
    setNewCloth((prev) => ({ ...prev, slika: e.target.files[0] }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    Object.keys(newCloth).forEach((key) => {
      formData.append(key, newCloth[key]);
    });

    await createCloth(formData);

    setNewCloth({
      naziv: '',
      tip: '',
      boja: '',
      sezona: '',
      materijal: '',
      garderober_id: id,
      slika: null,
    });
  };

  return (
    <section className="clothes-section">
      <h2 className="section-title">Odeća u garderoberu</h2>
      
      <form className="add-cloth-form" onSubmit={handleSubmit}>
        <input
          type="text"
          name="naziv"
          placeholder="Naziv"
          value={newCloth.naziv}
          onChange={handleInputChange}
          required
        />
        <input
          type="text"
          name="tip"
          placeholder="Tip"
          value={newCloth.tip}
          onChange={handleInputChange}
          required
        />
        <input
          type="text"
          name="boja"
          placeholder="Boja"
          value={newCloth.boja}
          onChange={handleInputChange}
          required
        />
        <input
          type="text"
          name="sezona"
          placeholder="Sezona"
          value={newCloth.sezona}
          onChange={handleInputChange}
          required
        />
        <input
          type="text"
          name="materijal"
          placeholder="Materijal"
          value={newCloth.materijal}
          onChange={handleInputChange}
        />
        <input type="file" name="slika" onChange={handleFileChange} />
        <button type="submit">Dodaj odeću</button>
      </form>

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
