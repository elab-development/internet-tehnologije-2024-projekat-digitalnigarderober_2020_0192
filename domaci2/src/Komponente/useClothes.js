import { useState, useEffect } from 'react';
import axios from 'axios';

const useClothes = (wardrobeId) => {
  const [clothes, setClothes] = useState([]);

  useEffect(() => {
    const fetchClothes = async () => {
      try {
        const token = sessionStorage.getItem('token');
        const response = await axios.get(`http://127.0.0.1:8000/api/garderoberi/${wardrobeId}/odeca`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setClothes(response.data);
      } catch (error) {
        console.error('Greška prilikom učitavanja odeće:', error);
      }
    };

    fetchClothes();
  }, [wardrobeId]);

  const createCloth = async (newCloth) => {
    try {
      const token = sessionStorage.getItem('token');
      const response = await axios.post(`http://127.0.0.1:8000/api/odeca`, newCloth, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setClothes((prevClothes) => [...prevClothes, response.data]);
    } catch (error) {
      console.error('Greška prilikom kreiranja odeće:', error);
    }
  };

  const deleteCloth = async (clothId) => {
    try {
      const token = sessionStorage.getItem('token');
      await axios.delete(`http://127.0.0.1:8000/api/odeca/${clothId}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setClothes((prevClothes) => prevClothes.filter((cloth) => cloth.id !== clothId));
    } catch (error) {
      console.error('Greška prilikom brisanja odeće:', error);
    }
  };

  return [clothes, setClothes, createCloth, deleteCloth];
};

export default useClothes;
