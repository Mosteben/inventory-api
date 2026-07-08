import { create } from "zustand";
import { setToken, setUser, clearStorage, getToken, getUser } from "../utils/storage";

type User = {
    id: number;
    name: string;
    role: string;
};

type AuthState = {
    token: string | null;
    user: User | null;

    login: (token: string, user: User) => void;
    logout: () => void;
};

export const useAuthStore = create<AuthState>((set) => ({

    token: getToken(),

    user: getUser(),

    login: (token, user) => {

        setToken(token);
        setUser(user);

        set({ token, user });

    },

    logout: () => {

        clearStorage();

        set({ token: null, user: null });

    }

}));