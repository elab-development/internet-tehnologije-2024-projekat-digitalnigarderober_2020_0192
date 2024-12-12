import { useState, useEffect } from 'react';
import axios from 'axios';

const useWardrobes = () => {
  const [wardrobes, setWardrobes] = useState([]);

  useEffect(() => {
    const fetchWardrobes = async () => {
      try {
        const token = sessionStorage.getItem('token'); // Dohvatanje tokena
        const response = await axios.get('http://127.0.0.1:8000/api/garderoberi', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setWardrobes(response.data); // Pretpostavljamo da API vraća niz garderobera
        console.log(response.data)
      } catch (error) {
        console.error('Greška prilikom učitavanja garderobera:', error);
      }
    };

    fetchWardrobes();
  }, []);

  return [wardrobes, setWardrobes];
};

export default useWardrobes;
