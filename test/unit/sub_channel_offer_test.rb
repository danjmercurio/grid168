# == Schema Information
#
# Table name: sub_channel_offers
#
#  id                :integer(4)      not null, primary key
#  yearly_offer      :float           default(0.0), not null
#  monthly_offer     :float           default(0.0), not null
#  weekly_offer      :float           default(0.0), not null
#  hourly_rate       :float           default(0.0), not null
#  total_hours       :float           default(0.0), not null
#  dollar_amount     :float           default(0.0), not null
#  half_hour_clicked :text
#  sub_channel_id    :integer(4)
#  created_at        :datetime
#  updated_at        :datetime
#  user_id           :integer(4)      not null
#

require 'test_helper'

class SubChannelOfferTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
