<template>
    <div class="container container-edit-dieta mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-edit-dieta">
            <div class="card-header text-center header-edit-dieta">
              Editar Dieta
            </div>
  
            <div class="card-body">
              <form @submit.prevent="guardarCambios">
                <!-- Nombre de la dieta -->
                <div class="form-group mb-3">
                  <label for="nombre_dieta" class="form-label">Nombre de la Dieta</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="dieta.nombre_dieta"
                    required
                  />
                </div>
  
                <!-- Descripción de la dieta -->
                <div class="form-group">
                  <label for="descripcion" class="form-label">Descripción de la Dieta</label>
                  <textarea
                    v-model="dieta.descripcion"
                    class="form-control"
                    rows="3"
                    placeholder="Escribe una descripción de la dieta..."
                  ></textarea>
                </div>
  
                <!-- Fechas -->
                <div class="form-group mb-3">
                  <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                  <input
                    type="date"
                    class="form-control"
                    v-model="dieta.fecha_inicio"
                    required
                  />
                </div>
                <div class="form-group mb-3">
                  <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                  <input
                    type="date"
                    class="form-control"
                    v-model="dieta.fecha_fin"
                  />
                </div>
  
                <!-- Alimentos para cada día de la semana -->
                <div v-for="dia in dias" :key="dia" class="form-group mb-3">
                  <h5 class="text-warning-dieta">{{ dia }}</h5>
  
                  <table class="table table-alimentos table-bordered">
                    <thead>
                      <tr>
                        <th>Alimento</th>
                        <th>Cantidad</th>
                        <th>Tiempo de comida</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(alimento, index) in alimentosPorDia[dia]" :key="index">
                        <td>
                          <select
                            v-model="alimento.id_alimento"
                            class="form-control"
                          >
                            <option
                              v-for="(tipo, idx) in alimentosPorTipo"
                              :key="idx"
                              :value="tipo.id_alimento"
                            >
                              {{ tipo.nombre_alimento }}
                            </option>
                          </select>
                        </td>
                        <td>
                          <input
                            type="number"
                            v-model="alimento.cantidad"
                            class="form-control"
                            placeholder="Cantidad (gr)"
                          />
                        </td>
                        <td>
                          <select v-model="alimento.tiempo_comida" class="form-control">
                            <option value="desayuno">Desayuno</option>
                            <option value="almuerzo">Almuerzo</option>
                            <option value="cena">Cena</option>
                            <option value="snack">Snack</option>
                          </select>
                        </td>
                        <td>
                          <button
                            type="button"
                            class="btn btn-danger"
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
                    class="btn btn-add-alimento"
                    @click="agregarFila(dia)"
                  >
                    Añadir Alimento
                  </button>
                </div>
  
                <div class="form-group mt-4 text-center">
                  <button type="submit" class="btn btn-save-dieta">Guardar Cambios</button>
                  <a href="#" class="btn btn-back-dieta">Regresar</a>
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
    data() {
      return {
        dias: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
        dieta: {
          nombre_dieta: '',
          descripcion: '',
          fecha_inicio: '',
          fecha_fin: '',
        },
        alimentosPorTipo: [
          { id_alimento: 1, nombre_alimento: 'Pollo' },
          { id_alimento: 2, nombre_alimento: 'Arroz' },
        ],
        alimentosPorDia: {
          Lunes: [],
          Martes: [],
          Miércoles: [],
          Jueves: [],
          Viernes: [],
          Sábado: [],
          Domingo: [],
        },
      };
    },
    methods: {
      agregarFila(dia) {
        this.alimentosPorDia[dia].push({
          id_alimento: '',
          cantidad: '',
          tiempo_comida: 'desayuno',
        });
      },
      eliminarFila(dia, index) {
        this.alimentosPorDia[dia].splice(index, 1);
      },
      guardarCambios() {
        console.log(this.dieta);
        console.log(this.alimentosPorDia);
      },
    },
  };
  </script>
  
  <style scoped>
  </style>  