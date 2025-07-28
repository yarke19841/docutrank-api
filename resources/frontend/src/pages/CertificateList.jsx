import { useEffect, useState } from "react";
import api from "../services/api";
import BackButton from "../components/BackButton";

export default function CertificateList() {
  const [certificates, setCertificates] = useState([]);

  useEffect(() => {
    const fetchCertificates = async () => {
      const token = localStorage.getItem("token");
      try {
        const res = await api.get("/certificates", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setCertificates(res.data.data); // Ajusta esto si tu backend devuelve un campo distinto
      } catch (err) {
        console.error("Error al obtener certificados:", err);
      }
    };

    fetchCertificates();
  }, []);

  return (
    <div>
      <BackButton />
      <h2>Mis Certificados</h2>
      <ul>
        {certificates.length === 0 ? (
          <p>No hay certificados aún.</p>
        ) : (
          certificates.map((cert) => (
            <li key={cert.id}>
              <strong>{cert.certificate_number}</strong> -{" "}
              <a href={cert.url} target="_blank" rel="noopener noreferrer">
                Descargar
              </a>
            </li>
          ))
        )}
      </ul>
    </div>
  );
}
