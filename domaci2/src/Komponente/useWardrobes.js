import { useState, useEffect } from 'react';
import axios from 'axios';

const useWardrobes = () => {
  const [wardrobes, setWardrobes] = useState([]);

  useEffect(() => {
    const fetchWardrobes = async () => {
      try {
        const token = sessionStorage.getItem('token');
        const response = await axios.get('http://127.0.0.1:8000/api/garderoberi', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setWardrobes(response.data);
      } catch (error) {
        console.error('Greška prilikom učitavanja garderobera:', error);
      }
    };

    fetchWardrobes();
  }, []);

  const addWardrobe = async (naziv, opis) => {
    try {
      const token = sessionStorage.getItem('token');
      const response = await axios.post(
        'http://127.0.0.1:8000/api/garderoberi',
        { naziv, opis },
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );
      setWardrobes((prev) => [...prev, response.data]);
    } catch (error) {
      console.error('Greška prilikom dodavanja garderobera:', error);
    }
  };

  const deleteWardrobe = async (id) => {
    try {
      const token = sessionStorage.getItem('token');
      await axios.delete(`http://127.0.0.1:8000/api/garderoberi/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setWardrobes((prev) => prev.filter((wardrobe) => wardrobe.id !== id));
    } catch (error) {
      console.error('Greška prilikom brisanja garderobera:', error);
    }
  };

  return [wardrobes, addWardrobe, deleteWardrobe];
};

export default useWardrobes;
