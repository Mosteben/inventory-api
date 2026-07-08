type ButtonProps = {

    children: React.ReactNode;

    type?:
        | "button"
        | "submit";

    onClick?: () => void;

    className?: string;

    disabled?: boolean;

};

function Button({

    children,

    type = "button",

    onClick,

    className = "",

    disabled = false,

}: ButtonProps) {

    return (

        <button

            type={type}

            onClick={onClick}

            disabled={disabled}

            className={`
                w-full
                rounded-lg
                bg-blue-600
                hover:bg-blue-700
                text-white
                py-3
                font-medium
                transition
                disabled:bg-gray-400
                ${className}
            `}

        >

            {children}

        </button>

    );

}

export default Button;