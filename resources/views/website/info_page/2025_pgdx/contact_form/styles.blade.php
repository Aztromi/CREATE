<style>
    #modal-game-form .input-group-text {
        width: 140px;
        justify-content: flex-start;
    }

    #modal-game-form .modal-body {
        border: 1px solid #353535;
        background-color: #151515;
        padding: 20px;
        border-radius: 20px;
    }

    #modal-game-form .form-container {
        display: flex;
        justify-content: center; /* centers horizontally */
        text-align: center;
    }

    #modal-game-form form {
        max-width: 400px;
    }

    #modal-game-form #game-label {
        color: #E5E5E5;
    }

    #modal-game-form #game-score-container {
        display: flex;
        justify-content: center; /* centers horizontally */
        text-align: center;
    }

    #modal-game-form #game-score-label {
        font-weight: bold;
        font-size: 1.5rem;

        padding: 0.2em 0.4em;
        display: inline-block;

        background: linear-gradient(
            90deg,
            #b8860b,
            #ffb800,
            #ff9900,
            #ffb800,
            #b8860b
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;

        /* Gold border for strong visual impact */
        border: 2px solid #daa520;
        border-radius: 0.25em;

        /* Optional: add some spacing or shadow */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    #modal-game-form #play-id-container {
        color: #555555;
        text-align: center;
        font-size: 1rem;
        font-weight: bold;
    }

    #modal-game-form .gen-format {
        color: #E5E5E5;
        line-height: 1.2;
    }

    #modal-game-form .btn-primary {
        background-color: rgb(19, 137, 188);
        border: 0;
    }

    #modal-game-form .btn-primary:hover {
        background-color:rgb(230, 145, 35);
        color: #E5E5E5;
        border: 0;
        font-weight: bold;
    }
</style>