import { useState } from 'react';
import api from '../services/api';
import BackButton from '../components/BackButton'; // 👈 Importamos el botón

export default function RequestForm() {
  const [form, setForm] = useState({
    certificate_type: 'Nacimiento',
    full_name: '',
    document_number: ''
  });
  const [file, setFile] = useState(null);
  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!file || file.type !== 'application/pdf') {
      setMessage('Debes subir un archivo PDF.');
      return;
    }

    const data = new FormData();
    data.append('certificate_type', form.certificate_type);
    data.append('full_name', form.full_name);
    data.append('document_number', form.document_number);
    data.append('document', file);

    try {
      const token = localStorage.getItem('token');
      await api.post('/certificaterequests', data, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'multipart/form-data'
        }
      });

      setMessage('Solicitud enviada exitosamente.');
      setForm({
        certificate_type: 'Nacimiento',
        full_name: '',
        document_number: ''
      });
      setFile(null);
    } catch (err) {
      const msg = err.response?.data?.errors?.document?.[0] || 'Error al enviar la solicitud';
      setMessage(msg);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <BackButton /> {/* 👈 Aquí está el botón de regreso */}

      <h2>Solicitar Certificado</h2>

      <label>Tipo de certificado:</label>
      <select name="certificate_type" value={form.certificate_type} onChange={handleChange}>
        <option value="Nacimiento">Nacimiento</option>
        <option value="Matrimonio">Matrimonio</option>
        <option value="Defunción">Defunción</option>
      </select>

      <input
        type="text"
        name="full_name"
        placeholder="Nombre completo"
        value={form.full_name}
        onChange={handleChange}
        required
      />

      <input
        type="text"
        name="document_number"
        placeholder="Número de documento"
        value={form.document_number}
        onChange={handleChange}
        required
      />

      <input
        type="file"
        accept=".pdf"
        onChange={e => setFile(e.target.files[0])}
        required
      />

      <button type="submit">Enviar solicitud</button>

      {message && <p>{message}</p>}
    </form>
  );
}
