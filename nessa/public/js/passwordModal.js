// public/js/passwordModal.js

function openPasswordModal() {
    console.log("Fonction openPasswordModal appelée");
    const modalRoot = document.getElementById('password-modal-root');
    modalRoot.innerHTML = '<div id="vue-password-modal"></div>';

    const { createApp, ref } = window.Vue;

    const PasswordModal = {
        template: `
            <div class="modal-overlay">
                <div class="modal-content">
                    <div v-if="step === 1" class="modal">
                        <h3>Confirmez votre mot de passe actuel</h3>
                        <input type="password" v-model="currentPassword" placeholder="Mot de passe actuel">
                        <div v-if="message" class="error-message"> {{ message }} </div>
                        <button @click="verifyCurrentPassword">Suivant</button>
                        <button @click="close">Annuler</button>
                    </div>
                    <div v-else-if="step === 2" class="modal">
                        <h3>Nouveau mot de passe</h3>
                        <input type="password" v-model="newPassword" placeholder="Nouveau mot de passe">
                        <input type="password" v-model="confirmPassword" placeholder="Confirmer le mot de passe">
                        <div v-if="message" class="error-message" style="margin-top: 5px;"> {{ message }} </div>
                        <button @click="saveNewPassword">Enregistrer</button>
                        <button @click="close">Annuler</button>
                    </div>
                </div>
            </div>
        `,
        setup() {
            const showModal = ref(true);
            const step = ref(1);
            const currentPassword = ref('');
            const newPassword = ref('');
            const confirmPassword = ref('');
            const message = ref('');

            async function verifyCurrentPassword() {
                try {
                    const response = await fetch('/verify-password', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            currentPassword: currentPassword.value
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        step.value = 2;
                        message.value = '';
                    } else {
                        message.value = result.message || 'Mot de passe incorrect.';
                    }
                } catch (error) {
                    message.value = 'Erreur de connexion au serveur.';
                }
            }

            async function saveNewPassword() {
                if (newPassword.value !== confirmPassword.value) {
                    message.value = 'Les mots de passe ne correspondent pas.';
                    return;
                }

                try {
                    const response = await fetch('/update-password', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            newPassword: newPassword.value,
                            confirmPassword: confirmPassword.value
                        })
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        message.value = 'Mot de passe mis à jour avec succès.';
                        // Fermer après succès
                        setTimeout(() => {
                            close();
                        }, 1000);
                    } else {
                        message.value = result.message || 'Erreur lors de la mise à jour.';
                    }
                } catch (error) {
                    message.value = 'Erreur de connexion au serveur.';
                }
            }

            function close() {
                const modalRoot = document.getElementById('password-modal-root');
                modalRoot.innerHTML = '';
            }

            return {
                showModal,
                step,
                currentPassword,
                newPassword,
                confirmPassword,
                message,
                verifyCurrentPassword,
                saveNewPassword,
                close
            };
        }
    };

    const app = createApp(PasswordModal);
    app.mount('#vue-password-modal');
}

// Rendez la fonction globale pour y accéder depuis le bouton Twig
window.openPasswordModal = openPasswordModal;
