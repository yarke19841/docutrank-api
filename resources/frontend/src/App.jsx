// src/App.jsx
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Dashboard from "./pages/Dashboard";
import RequestForm from "./pages/RequestForm";
import MyRequests from "./pages/MyRequests";
import CertificateList from "./pages/CertificateList";
import CertificateDownload from "./pages/CertificateDownload";
import AdminDashboard from "./pages/AdminDashboard";
import AdminRequestDetail from "./pages/AdminRequestDetail"; // 👈 nuevo
import AdminLayout from "./components/AdminLayout"; // 👈 layout

import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Dashboard from "./pages/Dashboard";
import RequestForm from "./pages/RequestForm";
import MyRequests from "./pages/MyRequests";
import CertificateList from "./pages/CertificateList";
import CertificateDownload from "./pages/CertificateDownload";
import AdminDashboard from "./pages/AdminDashboard";
import AdminRequestDetail from "./pages/AdminRequestDetail"; // 👈 nuevo
import AdminLayout from "./components/AdminLayout"; // 👈 layout

function App() {
  return (
    <Router>
      <Routes>
        {/* Público */}
        <Route path="/" element={<Login />} />
        <Route path="/login" element={<Login />} />
        <Route path="/registro" element={<Register />} />

        {/* Usuario */}
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/solicitar" element={<RequestForm />} />
        <Route path="/solicitudes" element={<MyRequests />} />
        <Route path="/certificados" element={<CertificateList />} />
        <Route path="/descargar-certificado/:id" element={<CertificateDownload />} />

        {/* ADMIN con layout */}
        <Route path="/admin" element={<AdminLayout />}>
          <Route path="dashboard" element={<AdminDashboard />} />
          <Route path="requests/:id" element={<AdminRequestDetail />} />
        </Route>
      </Routes>
    </Router>
  );
}


export default App;
