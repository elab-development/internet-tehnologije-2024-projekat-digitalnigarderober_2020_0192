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

  return [clothes, setClothes];
};

export default useClothes;