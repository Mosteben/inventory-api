import api from "./api";

class AuthService {
    register(payload: { name: string; email: string; password: string; }) {
        throw new Error("Method not implemented.");
    }

    async login(data: { email: string; password: string }) {

        const response = await api.post(
            "/auth/login",
            data
        );

        return response.data;

    }

}

export default new AuthService();