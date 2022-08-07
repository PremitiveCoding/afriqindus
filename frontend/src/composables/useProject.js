import { ref } from "@vue/reactivity";
import api from "../apis/api";

export function useProject() {
  let projects = ref({
    data: [],
    links: {},
    meta: {},
  });
  let loading = ref(false);

  function fetchProjects(params = {}) {
    let { page = 1, showMore = false } = params;

    loading.value = true;
    api.get('projects', { params: { page } })
      .then(response => {
        if (showMore) {
          projects.value = {
            ...response.data,
            data: [...projects.value.data, ...response.data.data],
          }
        } else {
          projects.value = response.data;
        }
      })
      .finally(() => loading.value = false);
  }

  let projectDetail = ref({ category: {} });
  let projectDetailLoading = ref(false);
  function fetchProjectDetail(params) {
    projectDetailLoading.value = false;
    api.get(`projects/${params.slug}`)
      .then(response => {
        projectDetail.value = response.data.data;
      })
      .finally(() => projectDetailLoading.value = true)
  }

  return {
    projects,
    loading,
    fetchProjects,
    projectDetail,
    projectDetailLoading,
    fetchProjectDetail,
  };
}