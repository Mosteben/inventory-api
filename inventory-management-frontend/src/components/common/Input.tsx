import { forwardRef } from "react";

type InputProps = {
    label: string;
    error?: string;
} & React.InputHTMLAttributes<HTMLInputElement>;

const Input = forwardRef<HTMLInputElement, InputProps>(
    (
        {
            label,
            error,
            className = "",
            ...props
        },
        ref
    ) => {

        return (

            <div className="mb-5">

                <label
                    className="
                        block
                        mb-2
                        text-sm
                        font-semibold
                        text-gray-700
                    "
                >
                    {label}
                </label>

                <input
                    ref={ref}
                    {...props}
                    className={`
                        w-full
                        rounded-lg
                        border
                        border-gray-300
                        px-4
                        py-3
                        outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-blue-500
                        transition
                        ${className}
                    `}
                />

                {

                    error && (

                        <p
                            className="
                                text-red-500
                                text-sm
                                mt-2
                            "
                        >
                            {error}
                        </p>

                    )

                }

            </div>

        );

    }
);

Input.displayName = "Input";

export default Input;