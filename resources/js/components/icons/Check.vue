<template>
    <v-avatar variant="tonal" color="greenLight" size="100">
        <div class="circle-check pt-6">
            <svg
                class="checkmark"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 52 52"
            >
                <circle
                    class="checkmark-circle"
                    cx="26"
                    cy="26"
                    r="25"
                    fill="none"
                />
                <path
                    class="checkmark-check"
                    fill="none"
                    d="M14.1 27.2l7.1 7.2 16.7-16.8"
                />
            </svg>
        </div>
    </v-avatar>
</template>
<style scoped>
.circle-check {
    margin-bottom: 20px;
}

.checkmark {
    width: 70px;
    height: 70px;
}

.checkmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke: #a5dc86;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards, fill 0.4s ease-in-out 0.4s forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    stroke-width: 2;
    stroke: #a5dc86;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
}

.alert p {
    font-size: 1rem;
    margin-bottom: 20px;
}

.alert-button {
    padding: 10px 20px;
    border: none;
    background-color: #a5dc86;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.alert-button:hover {
    background-color: #45a049;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes fill {
   
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
