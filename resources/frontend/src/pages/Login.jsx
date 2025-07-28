import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import api from '../services/api';

export default function Login() {
  const navigate = useNavigate();
  const [form, setForm] = useState({ email: '', password: '' });
  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage('');

    try {
    // Login
    const res = await api.post('/login', form);
    const token = res.data.token;
    localStorage.setItem('token', token);

    // Obtener información del usuario
    const me = await api.get('/me', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const role = me.data.role;

    setMessage('✅ Login exitoso. Redirigiendo...');

    // Redirigir según el rol
    setTimeout(() => {
      if (role === 'ADMIN') {
        navigate('/admin/dashboard');
      } else {
        navigate('/dashboard');
      }
    }, 1000);
  } catch (err) {
    console.error(err);
    setMessage('❌ Credenciales incorrectas.');
  }
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Iniciar Sesión</h2>
      <input
        type="email"
        name="email"
        placeholder="Correo"
        onChange={handleChange}
      />
      <input
        type="password"
        name="password"
        placeholder="Contraseña"
        onChange={handleChange}
      />
      <button type="submit">Ingresar</button>
      <p>{message}</p>

      <p>¿No tienes cuenta? <Link to="/register">Regístrate aquí</Link></p>
    </form>
  );
}
