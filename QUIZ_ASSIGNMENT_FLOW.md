# Quiz Assignment Flow - Multi-Admin System

## Current Flow (Open Access)

**Current Behavior:**
- ✅ Multiple admins can create quizzes (each admin manages their own quizzes)
- ❌ **No assignment mechanism** - All users can see ALL quizzes from ALL admins
- Users browse all available quiz categories and take any quiz they want

**Current User Flow:**
```
1. User logs in
2. User sees ALL quiz categories (from all admins)
3. User selects any category
4. User takes the quiz
5. Results are saved
```

**Problem:** There's no way to control which users can access which quizzes created by which admin.

---

## Recommended Assignment Flow Options

### **Option 1: Admin-to-User Assignment (Recommended)**

**Flow:**
```
1. Admin creates quiz/category
2. Admin assigns quiz/category to specific users
3. User logs in and sees ONLY assigned quizzes
4. User takes assigned quiz
5. Results tracked per user
```

**Database Structure Needed:**
- `quiz_assignments` table (pivot table)
  - `id`
  - `quiz_id` or `category_id` (assign by category or individual quiz)
  - `user_id`
  - `assigned_by` (admin who assigned)
  - `assigned_at`
  - `due_date` (optional)
  - `status` (pending, in_progress, completed)
  - `timestamps`

**Implementation Steps:**
1. Create migration for `quiz_assignments` table
2. Create `QuizAssignment` model
3. Add assignment methods to `QuizController`:
   - `assignToUsers()` - Assign quiz/category to multiple users
   - `unassignFromUser()` - Remove assignment
4. Modify `UserQuizController::index()` to show only assigned quizzes
5. Create admin UI for assigning quizzes to users

---

### **Option 2: User Group/Team Assignment**

**Flow:**
```
1. Admin creates quiz/category
2. Admin assigns to user groups/teams
3. Users in those groups see assigned quizzes
4. User takes quiz
```

**Database Structure:**
- `user_groups` table
- `group_quiz_assignments` table (many-to-many)
- Users belong to groups

---

### **Option 3: Role-Based Assignment**

**Flow:**
```
1. Admin creates quiz/category
2. Admin assigns to specific roles
3. Users with those roles see quizzes
```

**Database Structure:**
- Add `assigned_roles` column to quizzes/categories
- Use existing role system (Spatie Permission)

---

## Detailed Flow: Option 1 (Admin-to-User Assignment)

### **Step-by-Step Process:**

#### **Phase 1: Admin Creates Quiz**
```
Admin → Creates Category → Creates Quiz Questions
```
- Admin creates quiz category
- Admin adds quiz questions to category
- Quiz is stored with `created_by` = admin_id

#### **Phase 2: Admin Assigns Quiz to Users**
```
Admin → Selects Quiz/Category → Selects Users → Assigns
```
- Admin goes to "Assign Quiz" page
- Selects quiz category or individual quiz
- Selects one or multiple users
- Optionally sets due date
- Saves assignment

#### **Phase 3: User Takes Quiz**
```
User Login → Dashboard → Sees Assigned Quizzes → Takes Quiz → Results
```
- User logs in
- User sees only quizzes assigned to them
- User clicks on assigned quiz
- User takes quiz (same flow as current)
- Results saved with assignment tracking

#### **Phase 4: Admin Views Results**
```
Admin → Views Assigned Quizzes → Sees User Progress/Results
```
- Admin can see which users have taken assigned quizzes
- Admin can view individual user results
- Admin can see completion status

---

## Database Schema for Assignment System

```sql
-- Quiz Assignments Table
CREATE TABLE quiz_assignments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,  -- Assign entire category
    quiz_id BIGINT UNSIGNED NULL,      -- OR assign individual quiz
    user_id BIGINT UNSIGNED NOT NULL,
    assigned_by BIGINT UNSIGNED NOT NULL,  -- Admin who assigned
    due_date DATETIME NULL,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    started_at DATETIME NULL,
    completed_at DATETIME NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (category_id) REFERENCES quiz_categories(id) ON DELETE CASCADE,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES users(id) ON DELETE CASCADE,
    
    -- Ensure either category_id or quiz_id is set
    CHECK (category_id IS NOT NULL OR quiz_id IS NOT NULL)
);

-- Index for performance
CREATE INDEX idx_quiz_assignments_user ON quiz_assignments(user_id);
CREATE INDEX idx_quiz_assignments_category ON quiz_assignments(category_id);
CREATE INDEX idx_quiz_assignments_quiz ON quiz_assignments(quiz_id);
```

---

## Controller Methods Needed

### **QuizController (Admin Side)**
```php
// Assign category to users
public function assignCategoryToUsers(Request $request, $categoryId)

// Assign individual quiz to users  
public function assignQuizToUsers(Request $request, $quizId)

// View assignments for a quiz/category
public function viewAssignments($quizId)

// Remove assignment
public function removeAssignment($assignmentId)
```

### **UserQuizController (User Side)**
```php
// Modified index - show only assigned quizzes
public function index()
{
    // Get only assigned categories/quizzes for current user
    $assignments = QuizAssignment::where('user_id', Auth::id())
        ->where('status', '!=', 'completed')
        ->with(['category', 'quiz'])
        ->get();
    
    return view('user-quiz.index', compact('assignments'));
}
```

---

## UI Flow

### **Admin Side:**
1. **Quiz Management** (existing)
   - Create/Edit/Delete quizzes
   
2. **Assignment Management** (new)
   - "Assign Quiz" button on quiz list
   - Assignment page with:
     - Quiz/Category selector
     - User multi-select
     - Due date picker
     - Assign button
   - View assigned users for each quiz
   - View user progress/results

### **User Side:**
1. **Dashboard** (modified)
   - Shows "Assigned Quizzes" section
   - Shows quiz status (Pending, In Progress, Completed)
   - Shows due dates
   - "Take Quiz" button for pending/in-progress
   - "View Results" for completed

2. **Quiz Taking** (existing flow)
   - Same as current implementation

---

## Benefits of Assignment System

1. **Control**: Admins control who sees which quizzes
2. **Organization**: Better tracking of quiz distribution
3. **Accountability**: Know which users have taken which quizzes
4. **Flexibility**: Assign by category or individual quiz
5. **Deadlines**: Optional due dates for assignments
6. **Progress Tracking**: See completion status per user

---

## Implementation Priority

1. **High Priority:**
   - Create `quiz_assignments` table
   - Modify `UserQuizController::index()` to filter by assignments
   - Add assignment functionality to admin

2. **Medium Priority:**
   - Assignment management UI
   - Progress tracking
   - Due date enforcement

3. **Low Priority:**
   - Bulk assignment
   - Assignment templates
   - Email notifications

