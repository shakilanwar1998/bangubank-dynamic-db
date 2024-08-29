<?php include 'header.php'; ?>
            <!-- Transfer Form -->
            <div class="sm:rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="mt-4 text-sm text-gray-500">
                  <form
                    action="/post-transfer"
                    method="POST">
                    <!-- Recipient's Email Input -->
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="block w-full ring-0 outline-none py-2 text-gray-800 border-b placeholder:text-gray-400 md:text-4xl"
                      placeholder="Recipient's Email Address"
                      required />

                    <!-- Amount -->
                    <div class="relative mt-4 md:mt-8">
                      <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                        <span class="text-gray-400 md:text-4xl">$</span>
                      </div>
                      <input
                        type="number"
                        name="amount"
                        id="amount"
                        class="block w-full ring-0 outline-none pl-4 py-2 md:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 md:text-4xl"
                        placeholder="0.00"
                        required />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-5">
                      <button
                        type="submit"
                        class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg md:text-xl text-center">
                        Proceed
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

<?php include 'footer.php'; ?>
