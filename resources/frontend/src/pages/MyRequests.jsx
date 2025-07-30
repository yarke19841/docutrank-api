import { useEffect, useState } from "react";
import api from "../services/api";
import BackButton from "../components/BackButton";

export default function MyRequests() {
  const [requests, setRequests] = useState([]);
  const storageUrl = import.meta.env.VITE_STORAGE_URL; // ✅ Aquí lo declaras

  useEffect(() => {
    const fetchRequests = async () => {
      const token = localStorage.getItem("token");
      try {
        const res = await api.get("/my-requests", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setRequests(res.data.data);
      } catch (err) {
        console.error("Error al obtener solicitudes:", err);
      }
    };

    fetchRequests();
  }, []);

  return (
    <div>
      <BackButton />
      <h2>Mis Solicitudes</h2>
      {requests.length === 0 ? (
        <p>No tienes solicitudes registradas.</p>
      ) : (
        <ul>
          {requests.map((req) => (
            <li key={req.id} style={{ marginBottom: "1rem" }}>
              <strong>{req.tipo_certificado}</strong> <br />
              Estado: {req.status} <br />
              Etapa: {req.stage} <br />
              {req.stage === "Emitido" && req.certificate && (
                <a
                  href={`${storageUrl}/${req.certificate.file_path}`} // ✅ uso dinámico
                  download={`${req.certificate.certificate_number}.pdf`}
                  rel="noopener noreferrer"
                >
                  Descargar Certificado
                </a>
              )}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
