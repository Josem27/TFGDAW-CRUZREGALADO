<template>
  <div class="container container-create-rutina">
      <div class="row justify-content-center">
          <input 
              type="hidden"
              :value="id_usuario"  
              @input="$emit('update:id_usuario', $event.target.value)"
          >
          <div class="col-md-8">
              <div class="card card-create-rutina">
                  <div class="card-header card-header-create-rutina">
                      Crear Rutina
                  </div>

                  <div class="card-body">
                      <form @submit.prevent="guardarRutina">
                          <!-- Nombre de la rutina -->
                          <div class="form-group mb-3">
                              <label for="nombre_rutina" class="form-label">Nombre de la Rutina</label>
                              <input
                                  type="text"
                                  class="form-control"
                                  :value="rutina.nombre_rutina"
                                  @input="$emit('update:nombre_rutina', $event.target.value)"
                                  required
                              />
                          </div>

                          <!-- Descripción de la rutina -->
                          <div class="form-group">
                              <label for="descripcion" class="form-label">Descripción de la Rutina</label>
                              <textarea
                                  :value="rutina.descripcion"
                                  @input="$emit('update:descripcion', $event.target.value)"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Escribe una descripción de la rutina..."
                              ></textarea>
                          </div>

                          <!-- Fecha de inicio -->
                          <div class="form-group mb-3">
                              <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                              <input
                                  type="date"
                                  class="form-control"
                                  :value="rutina.fecha_inicio"
                                  @input="$emit('update:fecha_inicio', $event.target.value)"
                                  required
                              />
                          </div>

                          <!-- Fecha de fin -->
                          <div class="form-group mb-3">
                              <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                              <input
                                  type="date"
                                  class="form-control"
                                  :value="rutina.fecha_fin"
                                  @input="$emit('update:fecha_fin', $event.target.value)"
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
                                      <tr v-for="(ejercicio, index) in ejerciciosSeleccionados(dia)" :key="index">
                                          <td>
                                              <select
                                                  :value="ejercicio.id_ejercicio"
                                                  @change="$emit('update:ejercicioSeleccionado', { dia, index, value: $event.target.value })"
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
                                                  :value="ejercicio.series"
                                                  @input="$emit('update:ejercicioSeries', { dia, index, value: $event.target.value })"
                                                  class="form-control"
                                                  placeholder="Series"
                                              />
                                          </td>
                                          <td>
                                              <input
                                                  type="number"
                                                  :value="ejercicio.repeticiones"
                                                  @input="$emit('update:ejercicioRepeticiones', { dia, index, value: $event.target.value })"
                                                  class="form-control"
                                                  placeholder="Repeticiones"
                                              />
                                          </td>
                                          <td>
                                              <input
                                                  type="number"
                                                  :value="ejercicio.minutos"
                                                  @input="$emit('update:ejercicioMinutos', { dia, index, value: $event.target.value })"
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
                              <button type="submit" class="btn btn-save-rutina">Guardar Rutina</button>
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
      /**
       * ID del usuario al que pertenece la rutina.
       * @type {number}
       */
      id_usuario: {
          type: Number,
          required: true,
      },
      /**
       * Categorías de ejercicios disponibles para seleccionar.
       * @type {Array}
       */
      ejerciciosPorCategoria: {
          type: Array,
          required: true,
      },
      /**
       * Información de la rutina que se está creando o editando.
       * @type {Object}
       */
      rutina: {
          type: Object,
          required: true,
      }
  },
  data() {
      return {
          /**
           * Días de la semana para asignar los ejercicios.
           * @type {Array<string>}
           */
          dias: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
          /**
           * Ejercicios asignados para cada día de la semana.
           * @type {Object}
           */
          ejercicios: {
              Lunes: [],
              Martes: [],
              Miércoles: [],
              Jueves: [],
              Viernes: [],
              Sábado: [],
          },
      };
  },
  methods: {
      /**
       * Obtiene los ejercicios seleccionados para un día específico.
       * 
       * @param {string} dia - Día de la semana para obtener los ejercicios.
       * @returns {Array} - Lista de ejercicios para el día especificado.
       */
      ejerciciosSeleccionados(dia) {
          return this.ejercicios[dia] || [];
      },

      /**
       * Añade una nueva fila de ejercicio para el día especificado.
       * 
       * @param {string} dia - Día de la semana en el cual agregar el ejercicio.
       * @returns {void}
       */
      agregarFila(dia) {
          this.ejercicios[dia].push({
              id_ejercicio: '',
              series: '',
              repeticiones: '',
              minutos: '',
          });
      },

      /**
       * Elimina una fila de ejercicio para el día especificado.
       * 
       * @param {string} dia - Día de la semana del cual eliminar el ejercicio.
       * @param {number} index - Índice del ejercicio a eliminar.
       * @returns {void}
       */
      eliminarFila(dia, index) {
          this.ejercicios[dia].splice(index, 1);
      },

      /**
       * Guarda los cambios realizados en la rutina, incluyendo los ejercicios.
       * 
       * @returns {rutina}
       */
      guardarRutina() {
          const data = {
              ...this.rutina,
              id_usuario: this.id_usuario,
              ejercicios: this.ejercicios,
          };
          console.log(data);
      },
  },
};