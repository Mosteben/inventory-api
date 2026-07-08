import { useForm } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { Mail, Lock } from "lucide-react";

import Input from "../common/Input";
import Button from "../common/Button";

import { useNavigate } from "react-router-dom";
import AuthService from "../../services/auth.service";
import { useAuthStore } from "../../store/auth.store";
import { toast } from "react-toastify";

const schema = z.object({
    email: z.string().email("Enter a valid email address"),
    password: z.string().min(6, "Password must be at least 6 characters"),
});

type FormData = z.infer<typeof schema>;

function LoginForm() {

    const navigate = useNavigate();

    const login = useAuthStore((s) => s.login);

    const {
        register,
        handleSubmit,
        formState: { errors, isSubmitting }
    } = useForm<FormData>({
        resolver: zodResolver(schema)
    });

    const onSubmit = async (data: FormData) => {

        try {

            const res = await AuthService.login(data);

            login(res.token, res.user);

            toast.success("Welcome back");

            if (res.user.role === "admin") {
                navigate("/dashboard");
            }

            else if (res.user.role === "EMPLOYEE") {
                navigate("/dashboard");
            }

            else {
                navigate("/shop");
            }

        } catch (err: any) {

            toast.error(
                err.response?.data?.message || "Login failed, please try again"
            );

        }

    };

    return (

        <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">

            <div className="relative">
                <Mail className="pointer-events-none absolute left-3 top-[38px] h-4 w-4 text-[#16171B]/30" />
                <Input
                    label="Email"
                    type="email"
                    placeholder="you@company.com"
                    className="pl-10"
                    {...register("email")}
                    error={errors.email?.message}
                />
            </div>

            <div className="relative">
                <Lock className="pointer-events-none absolute left-3 top-[38px] h-4 w-4 text-[#16171B]/30" />
                <Input
                    label="Password"
                    type="password"
                    placeholder="••••••••"
                    className="pl-10"
                    {...register("password")}
                    error={errors.password?.message}
                />
            </div>

            <Button
                type="submit"
                disabled={isSubmitting}
                className="
                    w-full
                    rounded-xl
                    bg-[#16171B]
                    py-3.5
                    font-semibold
                    text-white
                    shadow-lg
                    shadow-black/10
                    transition
                    hover:bg-[#16171B]/85
                    disabled:opacity-60
                "
            >
                {isSubmitting ? "Signing in..." : "Log in"}
            </Button>

        </form>

    );

}

export default LoginForm;
