<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\ChatMessage;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\CourseDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const DEFAULT_PASSWORD = '12345679';

    public function run(): void
    {
        $users = $this->seedUsers();
        $categories = $this->seedCategories();
        $courses = $this->seedCourses($users, $categories);

        $this->seedCourseDocuments($courses);
        $this->seedEnrollments($users, $courses);
        $this->seedQuizzes($users, $courses);
        $this->seedChatMessages($users);
        $this->seedActivityLogs($users);
    }

    /**
     * @return array{student: User, teacher: User, student2: User}
     */
    private function seedUsers(): array
    {
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@gmail.com',
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'role' => 'student',
            'is_approved' => true,
        ]);

        $teacher = User::create([
            'name' => 'Dr. Sarah Jenkins',
            'email' => 'teacher@edumind.ai',
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'role' => 'teacher',
            'is_approved' => true,
        ]);

        $student2 = User::create([
            'name' => 'Michael Chen',
            'email' => 'student2@edumind.ai',
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'role' => 'student',
            'is_approved' => true,
        ]);

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@test.com',
                'password' => Hash::make(self::DEFAULT_PASSWORD),
                'role' => 'student',
                'is_approved' => true,
            ]);
        }

        return [
            'student' => $student,
            'teacher' => $teacher,
            'student2' => $student2,
        ];
    }

    /**
     * @return array{ai: Category, web: Category, data: Category, design: Category}
     */
    private function seedCategories(): array
    {
        return [
            'ai' => Category::create(['name' => 'AI', 'slug' => 'ai']),
            'web' => Category::create(['name' => 'Web Development', 'slug' => 'web-development']),
            'data' => Category::create(['name' => 'Data Science', 'slug' => 'data-science']),
            'design' => Category::create(['name' => 'Design', 'slug' => 'design']),
        ];
    }

    /**
     * @param array $users
     * @param array $categories
     * @return Course[]
     */
    private function seedCourses(array $users, array $categories): array
    {
        return [
            Course::create([
                'title' => 'Prompt Engineering',
                'slug' => 'prompt-engineering',
                'category_id' => $categories['ai']->id,
                'teacher_id' => $users['teacher']->id,
            ]),

            Course::create([
                'title' => 'Laravel Mastery',
                'slug' => 'laravel-mastery',
                'category_id' => $categories['web']->id,
                'teacher_id' => $users['teacher']->id,
            ]),

            Course::create([
                'title' => 'Data Visualization',
                'slug' => 'data-viz',
                'category_id' => $categories['data']->id,
                'teacher_id' => $users['teacher']->id,
            ]),
        ];
    }

    private function seedCourseDocuments(array $courses): void
    {
        foreach ($courses as $course) {
            CourseDocument::create([
                'course_id' => $course->id,
                'title' => 'Course Guide',
                'file_path' => '#',
                'type' => 'pdf',
            ]);

            CourseDocument::create([
                'course_id' => $course->id,
                'title' => 'Video Lesson',
                'file_path' => '#',
                'type' => 'video',
            ]);
        }
    }

    private function seedEnrollments(array $users, array $courses): void
    {
        Enrollment::create([
            'user_id' => $users['student']->id,
            'course_id' => $courses[0]->id,
            'progress' => 80,
            'status' => 'active',
        ]);

        Enrollment::create([
            'user_id' => $users['student']->id,
            'course_id' => $courses[1]->id,
            'progress' => 40,
            'status' => 'active',
        ]);

        Enrollment::create([
            'user_id' => $users['student2']->id,
            'course_id' => $courses[2]->id,
            'progress' => 100,
            'status' => 'completed',
        ]);
    }

    private function seedQuizzes(array $users, array $courses): void
    {
        $quiz = Quiz::create([
            'course_id' => $courses[0]->id,
            'title' => 'AI Basics Quiz',
            'passing_score' => 70,
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'What is AI?',
            'option_a' => 'Artificial Intelligence',
            'option_b' => 'Auto Input',
            'option_c' => 'Advanced Interface',
            'option_d' => 'None',
            'correct_option' => 'A',
        ]);

        QuizAttempt::create([
            'user_id' => $users['student']->id,
            'quiz_id' => $quiz->id,
            'score' => 85,
            'passed' => true,
        ]);
    }

    private function seedChatMessages(array $users): void
    {
        ChatMessage::create([
            'user_id' => $users['student']->id,
            'message' => 'Explain AI',
            'response' => 'AI is intelligence demonstrated by machines.',
        ]);
    }

    private function seedActivityLogs(array $users): void
    {
        ActivityLog::create([
            'user_id' => $users['student']->id,
            'activity_type' => 'login',
            'description' => 'User logged in',
        ]);

        ActivityLog::create([
            'user_id' => $users['student']->id,
            'activity_type' => 'course_started',
            'description' => 'Started learning AI course',
        ]);
    }
}
