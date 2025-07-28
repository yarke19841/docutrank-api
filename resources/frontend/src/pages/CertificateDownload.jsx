// src/pages/CertificateDownload.jsx
import { useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from "../services/api";

export default function CertificateDownload() {
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    const downloadCertificate = async () => {
      const token = localStorage.getItem("token");
      try {
        const res = await api.get(`/certificates/${id}/download`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
          responseType: "blob", // importante para descargar archivos
        });

        // Crear un enlace y simular clic
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "certificado.pdf");
        document.body.appendChild(link);
        link.click();

        // Limpiar y redirigir
        setTimeout(() => {
          navigate("/mis-solicitudes");
        }, 2000);
      } catch (err) {
        console.error("Error al descargar el certificado:", err);
        navigate("/mis-solicitudes");
      }
    };

    downloadCertificate();
  }, [id, navigate]);

  return (
    <div>
      <h3>Descargando certificado...</h3>
    </div>
  );
}
