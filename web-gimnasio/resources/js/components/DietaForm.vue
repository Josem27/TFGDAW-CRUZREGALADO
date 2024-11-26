<template>
    <div class="container mt-5">
        <input type="hidden" name="id_usuario" :value="id_usuario">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-create-dieta">
                    <div class="card-header text-center header-create-dieta">
                        Crear Dieta
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="submitForm">
                            <input type="hidden" name="id_usuario" :value="id_usuario">

                            <div class="form-group mb-3">
                                <label for="nombre_dieta" class="form-label">Nombre de la Dieta</label>
                                <input type="text" class="form-control" id="nombre_dieta" v-model="nombre_dieta" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion" class="form-label">Descripción de la Dieta</label>
                                <textarea id="descripcion" v-model="descripcion" class="form-control" rows="3" placeholder="Escribe una descripción de la dieta..."></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" v-model="fecha_inicio" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" v-model="fecha_fin" required>
                            </div>

                            <div v-for="dia in diasSemana" :key="dia" class="form-group mb-3">
                                <h5 class="text-warning">{{ dia }}</h5>

                                <table class="table table-dark table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Alimento</th>
                                            <th>Cantidad (gr)</th>
                                            <th>Tiempo de Comida</th>
                                            <th>Calorías</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(fila, index) in alimentosPorDia[dia]" :key="index">
                                            <td>
                                                <select v-model="fila.id_alimento" @change="actualizarCalorias(dia, index)" class="form-control">
                                                    <option v-for="(alimento, index) in alimentosPorTipo" :key="index" :value="alimento.id_alimento" :data-calorias="alimento.calorias">{{ alimento.nombre_alimento }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" v-model="fila.cantidad" class="form-control" placeholder="Cantidad (gr)" @input="actualizarCalorias(dia, index)">
                                            </td>
                                            <td>
                                                <select v-model="fila.tiempo_comida" class="form-control">
                                                    <option value="desayuno">Desayuno</option>
                                                    <option value="almuerzo">Almuerzo</option>
                                                    <option value="cena">Cena</option>
                                                    <option value="snack">Snack</option>
                                                </select>
                                            </td>
                                            <td>{{ fila.calorias }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger" @click="eliminarFila(dia, index)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="total-calorias-wrapper text-right">
                                    <strong>Calorías totales del día:</strong>
                                    <span>{{ calcularTotalCalorias(dia) }}</span>
                                </div>

                                <button type="button" class="btn btn-warning mt-2" @click="agregarFila(dia)">
                                    Añadir Alimento
                                </button>
                            </div>

                            <div class="form-group mt-4 text-center">
                                <button type="submit" class="btn btn-warning">Guardar Dieta</button>
                                <a :href="`/dietas/index/${id_usuario}`" class="btn btn-secondary">Regresar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id_usuario', 'alimentosPorTipo'],
    data() {
        return {
            nombre_dieta: '',
            descripcion: '',
            fecha_inicio: '',
            fecha_fin: '',
            diasSemana: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            alimentosPorDia: {
                Lunes: [],
                Martes: [],
                Miércoles: [],
                Jueves: [],
                Viernes: [],
                Sábado: []
            }
        };
    },
    methods: {
        agregarFila(dia) {
            this.alimentosPorDia[dia].push({
                id_alimento: '',
                cantidad: '',
                tiempo_comida: 'desayuno',
                calorias: 0
            });
        },
        eliminarFila(dia, index) {
            this.alimentosPorDia[dia].splice(index, 1);
        },
        actualizarCalorias(dia, index) {
            const fila = this.alimentosPorDia[dia][index];
            const alimentoSeleccionado = this.$refs[`alimento_${dia}_${index}`].find(option => option.value === fila.id_alimento);
            const caloriasPor100g = alimentoSeleccionado ? alimentoSeleccionado.getAttribute('data-calorias') : 0;
            fila.calorias = (caloriasPor100g * fila.cantidad) / 100;
        },
        calcularTotalCalorias(dia) {
            return this.alimentosPorDia[dia].reduce((total, fila) => total + parseFloat(fila.calorias || 0), 0).toFixed(2);
        },
        submitForm() {
            // Aquí enviarías el formulario, por ejemplo, con axios.
        }
    }
};
</script>

<style scoped>
/* Aquí van los estilos específicos para este componente */
</style>