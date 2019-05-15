import ApiService from '@/services/ApiService'
import * as types from './mutation_types'

export const del = ({ commit }, item) => {
  commit(types.USER_DELETE_TOGGLE_LOADING)

  return ApiService.delete(item['@id'], { method: 'DELETE' })
    .then(() => {
      commit(types.USER_DELETE_TOGGLE_LOADING)
      commit(types.USER_DELETE_SET_DELETED, item)
    })
    .catch((e) => {
      commit(types.USER_DELETE_TOGGLE_LOADING)
      commit(types.USER_DELETE_SET_ERROR, e.message)
    })
}

export const reset = ({ commit }) => {
  commit(types.USER_DELETE_RESET)
}
