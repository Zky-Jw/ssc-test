<script setup>
  import { ref, reactive } from 'vue';
	
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  const theadList = reactive(['#', 'Username', 'Action', 'Type', 'Timestamp'])
	import TitleDashboard from '@/Components/TitleDashboard.vue';

</script>

<template>
  <AuthenticatedLayout>
    <TitleDashboard :has-sync="true" :has-dropdown-month="true" :title="`List Unit`" >
			<button type="button" class="ml-4 py-2 px-4 inline-flex justify-center items-center gap-2 rounded-md border text-sm font-medium bg-white text-primary-400 shadow-sm align-middle hover:bg-gray-50">
				Sync
				<Icon class="text-lg text-primary-400" icon="fe:sync" />
			</button>
		</TitleDashboard>
    <div class="flex flex-col bg-white rounded-lg">
      <div class=" overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th v-for="item in theadList" :key="item" 
                    scope="col" class="px-6 py-3 text-left text-sm font-medium text-primary-300 break-words">{{ item }}
                  </th>
                </tr>
              </thead>
							<tbody class="divide-y divide-gray-200">
								<tr>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">01</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">Wade Warren</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words text-blue-500">Update</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">User</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">
										<span class="block mb-3">15 Feb 2023</span>
										<span class="block text-neutral-500">09:15</span>
									</td>
								</tr>
								<tr v-for="item in 5" :key="item">
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">0{{ item+1 }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">Wade Warren</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words text-green-500">Create</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">User</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-thin break-words">
										<span class="block mb-3">15 Feb 2023</span>
										<span class="block text-neutral-500">09:15</span>
									</td>
								</tr>
							</tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
	</AuthenticatedLayout>
</template>