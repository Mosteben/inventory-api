import { useForm } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { User, Mail, Lock } from "lucide-react";

import Input from "../common/Input";
import Button from "../common/Button";

import { useNavigate } from "react-router-dom";
import AuthService from "../../services/auth.service";
import { useAuthStore } from "../../store/auth.store";
import { toast } from "react-toastify";

const schema = z
    .object({
        name: z.string().min(2, "Enter your full name"),
        email: z.string().email("Enter a valid email address"),
        password: z.string().min(6, "Password must be at least 6 characters"),
        confirmPassword: z.string().min(6, "Please confirm your password"),
    })
    .refine((data) => data.password === data.confirmPassword, {
        message: "Passwords don't match",
        path: ["confirmPassword"],
    });

type FormData = z.infer<typeof schema>;

function RegisterForm() {

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

            const { confirmPassword, ...payload } = data;

            const res = await AuthService.register(payload) as unknown as {
                token?: string;
                user?: Record<string, unknown>;
            };

            // If the API signs the user in immediately, keep them logged in.
            if (res?.token && res?.user) {
                login(res.token, res.user);
                toast.success("Account created");
                navigate("/shop");
                return;
            }

            toast.success("Account created, please log in");
            navigate("/login");

        } catch (err: any) {

            toast.error(
                err.response?.data?.message || "Couldn't create your account, please try again"
            );

        }

    };

    return (

        <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">

            <div className="relative">
                <User className="pointer-events-none absolute left-3 top-[38px] h-4 w-4 text-white/30" />
                <Input
                    label="Full name"
                    type="text"
                    placeholder="Jane Doe"
                    className="pl-10"
                    {...register("name")}
                    error={errors.name?.message}
                />
            </div>

            <div className="relative">
                <Mail className="pointer-events-none absolute left-3 top-[38px] h-4 w-4 text-white/30" />
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
                <Lock className="pointer-events-none absolute left-3 top-[38px] h-4 w-4 text-white/30" />
                <Input
                    label="Password"
                    type="password"
                    placeholder="••••••••"
                    className="pl-10"
                    {...register("password")}
                    error={errors.password?.message}
                />
            </div>

            <div className="relative">
                <Lock className="pointer-events-none absolute left-3 top-[38px] h-4 w-4 text-white/30" />
                <Input
                    label="Confirm password"
                    type="password"
                    placeholder="••••••••"
                    className="pl-10"
                    {...register("confirmPassword")}
                    error={errors.confirmPassword?.message}
                />
            </div>

            <Button
                type="submit"
                disabled={isSubmitting}
                className="
                    w-full
                    rounded-xl
                    bg-gradient-to-r
                    from-[#7C5CFF]
                    to-[#6E4CFF]
                    py-3.5
                    font-semibold
                    text-white
                    shadow-lg
                    shadow-[#7C5CFF]/25
                    transition
                    hover:shadow-[#7C5CFF]/40
                    disabled:opacity-60
                "
            >
                {isSubmitting ? "Creating account..." : "Create account"}
            </Button>

        </form>

    );

}

export default RegisterForm;
