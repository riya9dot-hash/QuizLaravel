<x-app-layout>
    <x-slot name="header">
        <h2>Manage Languages</h2>
    </x-slot>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <!-- Header Section -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 25px; margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 5px 0;">My Created Languages</h1>
                    <p style="font-size: 14px; color: #6b7280; margin: 0;">Manage and organize your language settings</p>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" id="deleteSelectedBtn" style="display: none; align-items: center; gap: 8px; background: #ef4444; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(239, 68, 68, 0.3)';">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Selected
                    </button>
                    <a href="{{ route('languages.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 12px 24px; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(102, 126, 234, 0.3)';">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Language
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border-left: 4px solid #10b981;">
                <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border-left: 4px solid #ef4444;">
                <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span style="font-size: 14px; font-weight: 500;">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Table Card -->
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(180deg, #848177 0%, #000000 100%);">
                            <th style="padding: 16px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; width: 50px;">
                                <input type="checkbox" id="selectAll" style="width: 18px; height: 18px; cursor: pointer; accent-color: white;">
                            </th>
                            <th style="padding: 16px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">ID</th>
                            <th style="padding: 16px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Language Name</th>
                            <th style="padding: 16px 20px; text-align: left; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Created At</th>
                            <th style="padding: 16px 20px; text-align: center; color: white; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($languages as $language)
                            <tr class="table-row" style="border-bottom: 1px solid #f3f4f6; transition: all 0.2s ease;">
                                <td style="padding: 18px 20px;">
                                    <input type="checkbox" class="language-checkbox" data-language-id="{{ $language->id }}" style="width: 18px; height: 18px; cursor: pointer; accent-color: #848177;">
                                </td>
                                <td style="padding: 18px 20px; color: #6b7280; font-size: 14px; font-weight: 500;">#{{ $language->id }}</td>
                                <td style="padding: 18px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; background: linear-gradient(180deg, #848177 0%, #000000 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div style="color: #1f2937; font-size: 15px; font-weight: 600; margin-bottom: 2px;">{{ $language->name }}</div>
                                            <div style="color: #9ca3af; font-size: 12px;">Language</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 18px 20px; color: #6b7280; font-size: 13px;">
                                    {{ $language->created_at->format('M d, Y') }}
                                </td>
                                <td style="padding: 18px 20px;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        {{-- <a href="{{ route('languages.show', $language) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #eff6ff; color: #3b82f6; border-radius: 8px; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#dbeafe'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#eff6ff'; this.style.transform='scale(1)';" title="View Language">
                                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a> --}}
                                        <a href="{{ route('languages.edit', $language) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #f0f4ff; color: #848177; border-radius: 8px; text-decoration: none; transition: all 0.2s ease;" onmouseover="this.style.background='#e0e7ff'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#f0f4ff'; this.style.transform='scale(1)';" title="Edit Language">
                                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('languages.destroy', $language) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this language? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #fee2e2; color: #ef4444; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#fecaca'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#fee2e2'; this.style.transform='scale(1)';" title="Delete Language">
                                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 60px 20px; text-align: center;">
                                    <div style="max-width: 400px; margin: 0 auto;">
                                        <svg style="width: 80px; height: 80px; margin: 0 auto 20px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <h3 style="font-size: 18px; font-weight: 600; color: #374151; margin-bottom: 8px;">No languages found</h3>
                                        {{-- <p style="font-size: 14px; color: #6b7280; margin-bottom: 20px;">Get started by creating your first language</p>
                                        <a href="{{ route('languages.create') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #848177 0%, #000000 100%); color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Create Your First Language
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Table Row Hover Effect */
        .table-row:hover {
            background: #f9fafb !important;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            table {
                font-size: 13px;
            }
            
            th, td {
                padding: 12px 15px !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const languageCheckboxes = document.querySelectorAll('.language-checkbox');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

            // Select All functionality
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    languageCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateDeleteButton();
                });
            }

            // Individual checkbox change
            languageCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateDeleteButton();
                    // Update select all checkbox state
                    if (selectAllCheckbox) {
                        const allChecked = Array.from(languageCheckboxes).every(cb => cb.checked);
                        const someChecked = Array.from(languageCheckboxes).some(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                        selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    }
                });
            });

            // Update delete button visibility
            function updateDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.language-checkbox:checked');
                if (deleteSelectedBtn) {
                    if (checkedBoxes.length > 0) {
                        deleteSelectedBtn.style.display = 'inline-flex';
                    } else {
                        deleteSelectedBtn.style.display = 'none';
                    }
                }
            }

            // Delete selected button click
            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const checkedBoxes = document.querySelectorAll('.language-checkbox:checked');
                    
                    if (checkedBoxes.length === 0) {
                        alert('Please select at least one language to delete.');
                        return false;
                    }

                    // Collect selected language IDs
                    const languageIds = Array.from(checkedBoxes).map(cb => cb.getAttribute('data-language-id'));
                    
                    const count = languageIds.length;
                    if (confirm(`Are you sure you want to delete ${count} language(s)?`)) {
                        // Create a dynamic form and submit it
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("languages.bulk-delete") }}';
                        
                        // Add CSRF token
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfInput);
                        
                        // Add language IDs
                        languageIds.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'language_ids[]';
                            input.value = id;
                            form.appendChild(input);
                        });
                        
                        // Append form to body and submit
                        document.body.appendChild(form);
                        form.submit();
                    }
                    return false;
                });
            }

            // Initial button state
            updateDeleteButton();
        });
    </script>
</x-app-layout>
