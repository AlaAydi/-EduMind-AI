<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    private const QUIZ_TITLE = 'OOP Core Quiz';

    private const QUESTION_OOP = 'What are the principles of OOP?';

    private const QUESTION_FRAMEWORK = 'Which is a PHP framework?';

    private const ANSWER_OOP = 'A,B,C';
    private const ANSWER_FRAMEWORK = 'A,B';

    private User $teacher;
    private User $student;
    private Category $category;
    private Course $course;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacher = User::factory()->create(['role' => 'teacher']);
        $this->student = User::factory()->create(['role' => 'student']);

        $this->category = Category::create([
            'name' => 'Computer Science',
            'slug' => 'computer-science',
            'description' => 'CS Courses'
        ]);

        $this->course = Course::create([
            'title' => 'Laravel Advanced',
            'slug' => 'laravel-advanced',
            'description' => 'Mastering Laravel features',
            'level' => 'advanced',
            'category_id' => $this->category->id,
            'duration' => '3h 30m',
            'teacher_id' => $this->teacher->id
        ]);
    }

    public function test_teacher_can_create_quiz_with_checkbox_questions(): void
    {
        $response = $this->actingAs($this->teacher)->post('/quizzes', [
            'course_id' => $this->course->id,
            'title' => self::QUIZ_TITLE,
            'description' => 'Test your OOP principles understanding',
            'passing_score' => 70,
            'questions' => [
                [
                    'question_text' => self::QUESTION_OOP,
                    'option_a' => 'Heritage',
                    'option_b' => 'Polymorphism',
                    'option_c' => 'Abstraction',
                    'option_d' => 'Procedural',
                    'correct_options' => ['A', 'B', 'C']
                ],
                [
                    'question_text' => self::QUESTION_FRAMEWORK,
                    'option_a' => 'Laravel',
                    'option_b' => 'Symfony',
                    'option_c' => 'React',
                    'option_d' => 'Django',
                    'correct_options' => ['A', 'B']
                ]
            ]
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/quizzes');

        $this->assertDatabaseHas('quizzes', [
            'title' => self::QUIZ_TITLE,
            'passing_score' => 70,
        ]);

        $this->assertDatabaseHas('questions', [
            'question_text' => self::QUESTION_OOP,
            'correct_option' => self::ANSWER_OOP,
        ]);

        $this->assertDatabaseHas('questions', [
            'question_text' => self::QUESTION_FRAMEWORK,
            'correct_option' => self::ANSWER_FRAMEWORK,
        ]);
    }

    public function test_student_can_take_and_submit_quiz_and_be_graded_correctly(): void
    {
        Enrollment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id
        ]);

        $quiz = Quiz::create([
            'course_id' => $this->course->id,
            'title' => self::QUIZ_TITLE,
            'description' => 'Test your OOP principles understanding',
            'passing_score' => 70
        ]);

        $q1 = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => self::QUESTION_OOP,
            'option_a' => 'Heritage',
            'option_b' => 'Polymorphism',
            'option_c' => 'Abstraction',
            'option_d' => 'Procedural',
            'correct_option' => self::ANSWER_OOP
        ]);

        $q2 = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => self::QUESTION_FRAMEWORK,
            'option_a' => 'Laravel',
            'option_b' => 'Symfony',
            'option_c' => 'React',
            'option_d' => 'Django',
            'correct_option' => self::ANSWER_FRAMEWORK
        ]);

        $response = $this->actingAs($this->student)->post("/quizzes/{$quiz->id}/submit", [
            'answers' => [
                $q1->id => ['C', 'A', 'B'],
                $q2->id => ['A', 'B']
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('quiz_attempts', [
            'user_id' => $this->student->id,
            'quiz_id' => $quiz->id,
            'score' => 100,
            'passed' => true
        ]);

        $response = $this->actingAs($this->student)->post("/quizzes/{$quiz->id}/submit", [
            'answers' => [
                $q1->id => ['A', 'B'],
                $q2->id => ['A', 'B']
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('quiz_attempts', [
            'user_id' => $this->student->id,
            'quiz_id' => $quiz->id,
            'score' => 50,
            'passed' => false
        ]);
    }
}
