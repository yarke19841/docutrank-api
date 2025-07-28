import { useEffect, useState } from "react";
import api from "../services/api";
import BackButton from "../components/BackButton";

export default function MyRequests() {
  const [requests, setRequests] = useState([]);

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
            <li key={req.id}>
              <strong>{req.certificate_type}</strong> - Estado: <b>{req.status}</b>
              {req.certificate && (
                <div>
                  <span> Certificado generado: </span>
                  <a href={req.certificate.url} target="_blank" rel="noreferrer">
                    Descargar
                  </a>
                </div>
              )}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
