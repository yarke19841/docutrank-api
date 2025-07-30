import { useEffect, useState } from "react";
import api from "../services/api";
import BackButton from "../components/BackButton";

export default function CertificateList() {
  const [certificates, setCertificates] = useState([]);
const storageUrl = import.meta.env.VITE_STORAGE_URL;

  useEffect(() => {
    const fetchCertificates = async () => {
      const token = localStorage.getItem("token");
      try {
        const res = await api.get("/my-requests", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        // Filtrar solo las solicitudes con etapa "Emitido" que tengan un certificado generado
        const certificadosEmitidos = res.data.data.filter(
          (req) => req.stage === "Emitido" && req.certificate
        );

        setCertificates(certificadosEmitidos);
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
      {certificates.length === 0 ? (
        <p>No hay certificados emitidos aún.</p>
      ) : (
        <ul>
          {certificates.map((req) => (
            <li key={req.id} style={{ marginBottom: "1rem" }}>
              <strong>{req.certificate.certificate_number}</strong> –{" "}
         <a
  href={`${storageUrl}/${req.certificate.file_path}`}
  download={`${req.certificate.certificate_number}.pdf`}
  rel="noopener noreferrer"
>
  Descargar Certificado
</a>




            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
