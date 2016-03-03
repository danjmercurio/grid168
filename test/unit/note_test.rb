# == Schema Information
#
# Table name: notes
#
#  id         :integer(4)      not null, primary key
#  content    :text
#  offer_id   :integer(4)
#  created_at :datetime
#  updated_at :datetime
#

require 'test_helper'

class NoteTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
