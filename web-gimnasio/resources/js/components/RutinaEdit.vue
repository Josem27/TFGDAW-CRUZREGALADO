<template>
    <div class="container container-edit-rutina">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-edit-rutina">
            <div class="card-header card-header-edit-rutina">
              Editar Rutina
            </div>
  
            <div class="card-body">
              <form @submit.prevent="guardarCambios">
                <!-- Nombre de la rutina -->
                <div class="form-group mb-3">
                  <label for="nombre_rutina" class="form-label">Nombre de la Rutina</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="rutina.nombre_rutina"
                    required
                  />
                </div>
  
                <!-- Descripción de la rutina -->
                <div class="form-group">
                  <label for="descripcion" class="form-label">Descripción de la Rutina</label>
                  <textarea
                    v-model="rutina.descripcion"
                    class="form-control"
                    rows="3"
                    placeholder="Escribe una descripción de la rutina..."
                  ></textarea>
                </div>
  
                <!-- Fechas -->
                <div class="form-group mb-3">
                  <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                  <input
                    type="date"
                    class="form-control"
                    v-model="rutina.fecha_inicio"
                    required
                  />
                </div>
                <div class="form-group mb-3">
                  <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                  <input
                    type="date"
                    class="form-control"
                    v-model="rutina.fecha_fin"
                  />
                </div>
  
                <!-- Ejercicios para cada día de la semana -->
                <div v-for="dia in dias" :key="dia" class="form-group mb-3">
                  <h5 class="text-warning-rutina">{{ dia }}</h5>
  
                  <table class="table table-exercises table-bordered">
                    <thead>
                      <tr>
                        <th>Ejercicio</th>
                        <th>Series</th>
                        <th>Repeticiones</th>
                        <th>Minutos</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(ejercicio, index) in ejercicios[dia]" :key="index">
                        <td>
                          <select
                            v-model="ejercicio.id_ejercicio"
                            class="form-control"
                          >
                            <option
                              v-for="(categoria, idx) in ejerciciosPorCategoria"
                              :key="idx"
                              :value="categoria.id_ejercicio"
                            >
                              {{ categoria.nombre_ejercicio }}
                            </option>
                          </select>
                        </td>
                        <td>
                          <input
                            type="number"
                            v-model="ejercicio.series"
                            class="form-control"
                            placeholder="Series"
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            v-model="ejercicio.repeticiones"
                            class="form-control"
                            placeholder="Repeticiones"
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            v-model="ejercicio.minutos"
                            class="form-control"
                            placeholder="Minutos"
                          />
                        </td>
                        <td>
                          <button
                            type="button"
                            class="btn btn-delete-exercise"
                            @click="eliminarFila(dia, index)"
                          >
                            Eliminar
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
  
                  <button
                    type="button"
                    class="btn btn-add-exercise"
                    @click="agregarFila(dia)"
                  >
                    Añadir Ejercicio
                  </button>
                </div>
  
                <div class="form-group mt-4 text-center">
                  <button type="submit" class="btn btn-save-rutina">Guardar Cambios</button>
                  <a href="#" class="btn btn-back-rutina">Regresar</a>
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
    props: {
      id_usuario: {
        type: Number,
        required: true,
      },
      ejerciciosPorCategoria: {
        type: Object,
        required: true,
      },
      rutinaSeleccionada: {
        type: Object,
        required: true,
      }
    },
    data() {
      return {
        dias: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        rutina: {
          id_rutina: this.rutinaSeleccionada.id_rutina,
          nombre_rutina: this.rutinaSeleccionada.nombre_rutina,
          descripcion: this.rutinaSeleccionada.descripcion,
          fecha_inicio: this.rutinaSeleccionada.fecha_inicio,
          fecha_fin: this.rutinaSeleccionada.fecha_fin,
        },
        ejercicios: {
          Lunes: [...this.rutinaSeleccionada.ejercicios.Lunes],
          Martes: [...this.rutinaSeleccionada.ejercicios.Martes],
          Miércoles: [...this.rutinaSeleccionada.ejercicios.Miércoles],
          Jueves: [...this.rutinaSeleccionada.ejercicios.Jueves],
          Viernes: [...this.rutinaSeleccionada.ejercicios.Viernes],
          Sábado: [...this.rutinaSeleccionada.ejercicios.Sábado],
        },
      };
    },
    methods: {
      agregarFila(dia) {
        this.ejercicios[dia].push({
          id_ejercicio: '',
          series: '',
          repeticiones: '',
          minutos: '',
        });
      },
      eliminarFila(dia, index) {
        this.ejercicios[dia].splice(index, 1);
      },
      guardarCambios() {
        const data = {
          ...this.rutina,
          ejercicios: this.ejercicios,
        };
        console.log(data);
      },
    },
  };
  </script>
  
  <style scoped>
  </style>  