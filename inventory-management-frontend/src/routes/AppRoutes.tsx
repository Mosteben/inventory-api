import { Routes, Route, Navigate } from "react-router-dom";


import LoginPage from "../pages/auth/LoginPage";
import DashboardPage from "../pages/dashboard/DashboardPage";
import ShopPage from "../pages/customer/ShopPage.tsx";
import LandingPage from "../pages/public/LandingPage.tsx";
import RegisterPage from "../pages/auth/register.tsx";


function AppRoutes() {

    return (

        <Routes>
           <Route path="/" element={<LandingPage />} />
<Route path="/login" element={<LoginPage />} />
<Route path="/register" element={<RegisterPage />} />

            <Route
                path="/dashboard"
                element={<DashboardPage />}
            />

            <Route
                path="/shop"
                element={<ShopPage />}
            />

            <Route
                path="*"
                element={
                    <h1
                        className="
                            text-center
                            text-4xl
                            mt-20
                        "
                    >
                        404 Not Found
                    </h1>
                }
            />

        </Routes>

    );

}

export default AppRoutes;