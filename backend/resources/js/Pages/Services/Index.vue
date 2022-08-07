<template>
  <app-layout>
    <template #header>
      <Breadcrumbs :items="breadcrumbs" />
    </template>

    <Container>
      <jet-button :href="route('services.create')">Add new</jet-button>

      <Card class="mt-4">
        <AppTable :headers="headers"
                  :items="services">
          <tr v-for="service in services.data"
              :key="service.id">
            <td>{{ service.title }}</td>
            <td>{{ service.category.name }}</td>
            <td>{{ service.created_at_for_human }}</td>
            <td>
              <div class="flex items-center justify-end space-x-2">
                <EditBtn :url="route('services.edit', {service: service.id})" />
                <DeleteBtn :url="route('services.destroy', {service: service.id})"
                           module-name="service" />
              </div>
            </td>
          </tr>
        </AppTable>
      </Card>
    </Container>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import EditBtn from "@/Components/EditBtn";
import DeleteBtn from "@/Components/DeleteBtn";
import SimplePagination from "@/Components/SimplePagination";
import AppTable from "@/Components/Table";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import Breadcrumbs from "@/Components/Breadcrumbs";
import JetButton from "@/Jetstream/Button";

export default {
  props: {
    services: {},
  },

  components: {
    AppLayout,
    EditBtn,
    DeleteBtn,
    SimplePagination,
    AppTable,
    JetButton,
    Container,
    Card,
    Breadcrumbs,
  },

  computed: {
    headers() {
      return [
        {
          name: "Title",
        },
        {
          name: "Category",
        },
        {
          name: "Created Date",
        },
        {
          name: "Action",
          class: "text-right",
        },
      ];
    },

    breadcrumbs() {
      return [
        {
          label: "Services",
        },
      ];
    },
  },
};
</script>
