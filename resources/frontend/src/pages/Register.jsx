import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import api from '../services/api';

export default function Register() {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    name: '',
    email: '',
    password: '',
    role: 'USER',
  });
  const [message, setMessage] = useState('');
  const [success, setSuccess] = useState(false); // 👈 para controlar el éxito

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage('');
    setSuccess(false);

    try {
      const res = await api.post('/register', form);
      localStorage.setItem('token', res.data.token);
      setSuccess(true);
      setMessage('✅ Registro exitoso. Redirigiendo al login...');
      setTimeout(() => navigate('/'), 1500);
    } catch (err) {
      if (err.response?.status === 422) {
        const errors = err.response.data.errors;
        const firstError = Object.values(errors)[0][0];
        setMessage(`❌ ${firstError}`);
      } else {
        setMessage('❌ Error al registrarse.');
      }
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Registro</h2>

      <input
        type="text"
        name="name"
        placeholder="Nombre completo"
        onChange={handleChange}
      />
      <input
        type="email"
        name="email"
        placeholder="Correo"
        onChange={handleChange}
      />
      <input
        type="password"
        name="password"
        placeholder="Contraseña (mínimo 6 caracteres)"
        onChange={handleChange}
      />
      <select name="role" value={form.role} onChange={handleChange}>
        <option value="USER">Usuario</option>
        <option value="ADMIN">Administrador</option>
      </select>

      <button type="submit">Registrarse</button>

      {/* Mensaje de éxito o error */}
      {message && <p>{message}</p>}

      {/* Solo mostramos el enlace si no hubo éxito */}
      {!success && (
        <p>¿Ya tienes cuenta? <Link to="/">Inicia sesión</Link></p>
      )}
    </form>
  );
}
