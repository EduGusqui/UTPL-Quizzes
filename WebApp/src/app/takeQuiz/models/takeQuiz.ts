import { AssignQuiz } from "../../assignQuiz/models/assignQuiz";
import { Question } from "../../question/models/question";

export class TakeQuiz {
	constructor(
		public Id?: number,
		public Questions?: Question[],
		public AssignQuiz?: AssignQuiz,
		public AttempNumber?: number,
		public Score?: number
	) {}
}