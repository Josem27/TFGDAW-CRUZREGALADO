import './bootstrap';
import { createApp } from 'vue';
import DietaForm from './components/DietaForm.vue';
import DietaEdit from './components/DietaEdit.vue';
import RutinaForm from './components/RutinaForm.vue';
import RutinaEdit from './components/RutinaEdit.vue';

const app = createApp({});
app.component('dieta-form', DietaForm);
app.component('dieta-edit', DietaEdit);
app.component('rutina-form', RutinaForm);
app.component('rutina-edit', RutinaEdit);
app.mount('#app');
